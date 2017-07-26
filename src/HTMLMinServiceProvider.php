<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Raza Mehdi <srmk@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HTMLMin\HTMLMin;

use HTMLMin\HTMLMin\Compilers\MinifyCompiler;
use HTMLMin\HTMLMin\Minifiers\BladeMinifier;
use HTMLMin\HTMLMin\Minifiers\CssMinifier;
use HTMLMin\HTMLMin\Minifiers\HtmlMinifier;
use HTMLMin\HTMLMin\Minifiers\JsMinifier;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;
use Laravel\Lumen\Application as LumenApplication;

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
            $this->enableBladeOptimisations();
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

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('htmlmin.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('htmlmin');
        }

        $this->mergeConfigFrom($source, 'htmlmin');
    }

    /**
     * Enable blade optimisations.
     *
     * @return void
     */
    protected function enableBladeOptimisations()
    {
        $app = $this->app;

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
        $this->registerJsMinifier();
        $this->registerCssMinifier();
        $this->registerHtmlMinifier();
        $this->registerBladeMinifier();
        $this->registerMinifyCompiler();
        $this->registerHTMLMin();
    }

    /**
     * Register the css minifier class.
     *
     * @return void
     */
    protected function registerCssMinifier()
    {
        $this->app->singleton('htmlmin.css', function () {
            return new CssMinifier();
        });

        $this->app->alias('htmlmin.css', CssMinifier::class);
    }

    /**
     * Register the js minifier class.
     *
     * @return void
     */
    protected function registerJsMinifier()
    {
        $this->app->singleton('htmlmin.js', function () {
            return new JsMinifier();
        });

        $this->app->alias('htmlmin.js', JsMinifier::class);
    }

    /**
     * Register the html minifier class.
     *
     * @return void
     */
    protected function registerHtmlMinifier()
    {
        $this->app->singleton('htmlmin.html', function (Container $app) {
            $css = $app['htmlmin.css'];
            $js = $app['htmlmin.js'];

            return new HtmlMinifier($css, $js);
        });

        $this->app->alias('htmlmin.html', HtmlMinifier::class);
    }

    /**
     * Register the blade minifier class.
     *
     * @return void
     */
    protected function registerBladeMinifier()
    {
        $this->app->singleton('htmlmin.blade', function (Container $app) {
            $force = $app->config->get('htmlmin.force', false);

            return new BladeMinifier($force);
        });

        $this->app->alias('htmlmin.blade', BladeMinifier::class);
    }

    /**
     * Register the minify compiler class.
     *
     * @return void
     */
    protected function registerMinifyCompiler()
    {
        $this->app->singleton('htmlmin.compiler', function (Container $app) {
            $blade = $app['htmlmin.blade'];
            $files = $app['files'];
            $storagePath = $app->config->get('view.compiled');
            $ignoredPaths = $app->config->get('htmlmin.ignore', []);

            return new MinifyCompiler($blade, $files, $storagePath, $ignoredPaths);
        });

        $this->app->alias('htmlmin.compiler', MinifyCompiler::class);
    }

    /**
     * Register the htmlmin class.
     *
     * @return void
     */
    protected function registerHTMLMin()
    {
        $this->app->singleton('htmlmin', function (Container $app) {
            $blade = $app['htmlmin.blade'];
            $css = $app['htmlmin.css'];
            $js = $app['htmlmin.js'];
            $html = $app['htmlmin.html'];

            return new HTMLMin($blade, $css, $js, $html);
        });

        $this->app->alias('htmlmin', HTMLMin::class);
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
