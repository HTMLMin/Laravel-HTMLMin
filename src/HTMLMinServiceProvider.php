<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\HTMLMin;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;

/**
 * This is the htmlmin service provider class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class HTMLMinServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('graham-campbell/htmlmin', 'graham-campbell/htmlmin', __DIR__);

        // setup blade optimisations if enabled
        if ($this->app['config']['graham-campbell/htmlmin::blade']) {
            $this->enableBladeOptimisations();
        }

        // setup live optimisations if enabled
        if ($this->app['config']['graham-campbell/htmlmin::live']) {
            $this->enableLiveOptimisations();
        }

        include __DIR__.'/filters.php';
    }

    /**
     * Enable blade optimisations.
     *
     * @return void
     */
    protected function enableBladeOptimisations()
    {
        $app = $this->app;

        // register a new engine
        $app['view']->getEngineResolver()->register('blade', function () use ($app) {
            $compiler = $app['htmlmin.compiler'];

            return new CompilerEngine($compiler);
        });

        // add the extension
        $app->view->addExtension('blade.php', 'blade');
    }

    /**
     * Enable live optimisations.
     *
     * @return void
     */
    protected function enableLiveOptimisations()
    {
        $app = $this->app;

        // register a new filter
        $app->after(function ($request, $response) use ($app) {
            $app['htmlmin']->live($response);
        });
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
        $this->app->bindShared('htmlmin.css', function ($app) {
            return new Minifiers\CssMinifier();
        });

        $this->app->alias('htmlmin.css', 'GrahamCampbell\HTMLMin\Minifiers\CssMinifier');
    }

    /**
     * Register the js minifier class.
     *
     * @return void
     */
    protected function registerJsMinifier()
    {
        $this->app->bindShared('htmlmin.js', function ($app) {
            return new Minifiers\JsMinifier();
        });

        $this->app->alias('htmlmin.js', 'GrahamCampbell\HTMLMin\Minifiers\JsMinifier');
    }

    /**
     * Register the html minifier class.
     *
     * @return void
     */
    protected function registerHtmlMinifier()
    {
        $this->app->bindShared('htmlmin.html', function ($app) {
            $css = $app['htmlmin.css'];
            $js = $app['htmlmin.js'];

            return new Minifiers\HtmlMinifier($css, $js);
        });

        $this->app->alias('htmlmin.html', 'GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier');
    }

    /**
     * Register the blade minifier class.
     *
     * @return void
     */
    protected function registerBladeMinifier()
    {
        $this->app->bindShared('htmlmin.blade', function ($app) {
            $force = $app['config']['graham-campbell/htmlmin::force'];

            return new Minifiers\BladeMinifier($force);
        });

        $this->app->alias('htmlmin.blade', 'GrahamCampbell\HTMLMin\Minifiers\BladeMinifier');
    }

    /**
     * Register the minify compiler class.
     *
     * @return void
     */
    protected function registerMinifyCompiler()
    {
        $this->app->bindShared('htmlmin.compiler', function ($app) {
            $blade = $app['htmlmin.blade'];
            $files = $app['files'];
            $storagePath = $app['path.storage'].'/views';

            return new Compilers\MinifyCompiler($blade, $files, $storagePath);
        });

        $this->app->alias('htmlmin.compiler', 'GrahamCampbell\HTMLMin\Compilers\MinifyCompiler');
    }

    /**
     * Register the htmlmin class.
     *
     * @return void
     */
    protected function registerHTMLMin()
    {
        $this->app->bindShared('htmlmin', function ($app) {
            $blade = $app['htmlmin.blade'];
            $css = $app['htmlmin.css'];
            $js = $app['htmlmin.js'];
            $html = $app['htmlmin.html'];

            return new HTMLMin($blade, $css, $js, $html);
        });

        $this->app->alias('htmlmin', 'GrahamCampbell\HTMLMin\HTMLMin');
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
