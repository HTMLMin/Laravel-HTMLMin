<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\HTMLMin;

use GrahamCampbell\HTMLMin\Compilers\MinifyCompiler;
use GrahamCampbell\HTMLMin\Minifiers\BladeMinifier;
use GrahamCampbell\HTMLMin\Minifiers\CssMinifier;
use GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier;
use GrahamCampbell\HTMLMin\Minifiers\JsMinifier;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;

/**
 * This is the htmlmin service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class HTMLMinServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();

        if ($this->app->config->get('htmlmin.blade')) {
            $this->enableBladeOptimisations($this->app);
        }
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/htmlmin.php');

        if (class_exists('Illuminate\Foundation\Application', false)) {
            $this->publishes([$source => config_path('htmlmin.php')]);
        }

        $this->mergeConfigFrom($source, 'htmlmin');
    }

    /**
     * Enable blade optimisations.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function enableBladeOptimisations(Application $app)
    {
        $app->view->getEngineResolver()->register('blade', function () use ($app) {
            $compiler = $app['htmlmin.compiler'];

            return new CompilerEngine($compiler);
        });

        $app->view->addExtension('blade.php', 'blade');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerJsMinifier($this->app);
        $this->registerCssMinifier($this->app);
        $this->registerHtmlMinifier($this->app);
        $this->registerBladeMinifier($this->app);
        $this->registerMinifyCompiler($this->app);
        $this->registerHTMLMin($this->app);
    }

    /**
     * Register the css minifier class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerCssMinifier(Application $app)
    {
        $app->singleton('htmlmin.css', function () {
            return new CssMinifier();
        });

        $app->alias('htmlmin.css', CssMinifier::class);
    }

    /**
     * Register the js minifier class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerJsMinifier(Application $app)
    {
        $app->singleton('htmlmin.js', function () {
            return new JsMinifier();
        });

        $app->alias('htmlmin.js', JsMinifier::class);
    }

    /**
     * Register the html minifier class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerHtmlMinifier(Application $app)
    {
        $app->singleton('htmlmin.html', function ($app) {
            $css = $app['htmlmin.css'];
            $js = $app['htmlmin.js'];

            return new HtmlMinifier($css, $js);
        });

        $app->alias('htmlmin.html', HtmlMinifier::class);
    }

    /**
     * Register the blade minifier class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerBladeMinifier(Application $app)
    {
        $app->singleton('htmlmin.blade', function ($app) {
            $force = $app->config->get('htmlmin.force', false);

            return new BladeMinifier($force);
        });

        $app->alias('htmlmin.blade', BladeMinifier::class);
    }

    /**
     * Register the minify compiler class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerMinifyCompiler(Application $app)
    {
        $app->singleton('htmlmin.compiler', function ($app) {
            $blade = $app['htmlmin.blade'];
            $files = $app['files'];
            $storagePath = $app->config->get('view.compiled');

            return new MinifyCompiler($blade, $files, $storagePath);
        });

        $app->alias('htmlmin.compiler', MinifyCompiler::class);
    }

    /**
     * Register the htmlmin class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerHTMLMin(Application $app)
    {
        $app->singleton('htmlmin', function ($app) {
            $blade = $app['htmlmin.blade'];
            $css = $app['htmlmin.css'];
            $js = $app['htmlmin.js'];
            $html = $app['htmlmin.html'];

            return new HTMLMin($blade, $css, $js, $html);
        });

        $app->alias('htmlmin', HTMLMin::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'htmlmin',
            'htmlmin.js',
            'htmlmin.css',
            'htmlmin.html',
            'htmlmin.blade',
            'htmlmin.compiler',
        ];
    }
}
