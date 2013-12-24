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
 * @copyright  Copyright 2013 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/develop/LICENSE.md
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
        $this->package('graham-campbell/htmlmin');

        // setup blade optimisations if enabled
        if ($this->app['config']['htmlmin::blade']) {
            $this->enableBladeOptimisations();
        }

        // setup live optimisations if enabled
        if ($app['config']['htmlmin::live']) {
            $this->enableLiveOptimisations();
        }
    }

    /**
     * Enable blade optimisations.
     *
     * @return void
     */
    protected function enableBladeOptimisations()
    {
        $app = $this->app;

        // register a new compiler
        $app->view->getEngineResolver()->register('blade.php', function () use ($app) {
            $htmlmin = $app['htmlmin'];
            $files = $app['files'];
            $storagePath = $app['path'].'/storage/views';

            $compiler = new Compilers\HTMLMinCompiler($htmlmin, $files, $storagePath);

            return new CompilerEngine($compiler);
        });

        // add the extension
        $app->view->addExtension('blade.php', 'blade.php');
    }

    /**
     * Enable live optimisations.
     *
     * @return void
     */
    protected function enableLiveOptimisations()
    {
        $app = $this->app;

        // after filter
        $app->after(function ($request, $response) use ($app) {
            // check if the response has a content type header
            if ($response->headers->has('Content-Type') !== false) {
                // check if the contact type header is html
                if (strpos($response->headers->get('Content-Type'), 'text/html') !== false) {
                    // get the response body
                    $output = $response->getOriginalContent();
                    // minify the response body
                    $min = $app['htmlmin']->render($output);
                    // set the response body
                    $response->setContent($min);
                }
            }
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHTMLMin();
    }

    /**
     * Register the htmlmin class.
     *
     * @return void
     */
    protected function registerHTMLMin()
    {
        $this->app->bindShared('htmlmin', function ($app) {
            $view = $app['view'];

            return new Classes\HTMLMin($view);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('htmlmin');
    }
}
