<?php

/**
 * This file is part of Laravel HTMLMin by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\HTMLMin;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;

/**
 * This is the htmlmin service provider class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
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
            $this->app['htmlmin']->live($response);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHtmlMinifier();
        $this->registerBladeMinifier();
        $this->registerMinifyCompiler();
        $this->registerHTMLMin();
    }

    /**
     * Register the html minifier class.
     *
     * @return void
     */
    protected function registerHtmlMinifier()
    {
        $this->app->bindShared('htmlmin.html', function ($app) {
            return new Minifiers\Html();
        });
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

            return new Minifiers\Blade($force);
        });
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
    }

    /**
     * Register the htmlmin class.
     *
     * @return void
     */
    protected function registerHTMLMin()
    {
        $this->app->bindShared('htmlmin', function ($app) {
            $html = $app['htmlmin.html'];
            $blade = $app['htmlmin.blade'];

            return new Classes\HTMLMin($html, $blade);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'htmlmin',
            'htmlmin.html',
            'htmlmin.blade',
            'htmlmin.compiler'
        );
    }
}
