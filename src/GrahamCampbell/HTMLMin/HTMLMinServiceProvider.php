<?php namespace GrahamCampbell\HTMLMin;

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
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @license    Apache License
 * @copyright  Copyright 2013 Graham Campbell
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Response;
use Illuminate\View\Engines\CompilerEngine;

class HTMLMinServiceProvider extends ServiceProvider {

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
    public function boot() {
        $this->package('graham-campbell/htmlmin');

        $app = $this->app;

        if ($app['config']['htmlmin::blade']) {
            $app->view->getEngineResolver()->register('blade.php', function() use ($app) {
                $compiler = new Classes\HTMLMinCompiler($app['htmlmin'], $app['files'], $app['path'].'/storage/views');
                return new CompilerEngine($compiler);
            });

            $app->view->addExtension('blade.php', 'blade.php');
        }

        if ($app['config']['htmlmin::live']) {
            $app->after(function($request, $response) use ($app) {
                if($response instanceof Response) {
                    if ($response->headers->has('Content-Type') !== false) {
                        if (strpos($response->headers->get('Content-Type'), 'text/html') !== false) {
                            $output = $response->getOriginalContent();
                            $min = $app['htmlmin']->render($output);
                            $response->setContent($min);
                        }
                    }
                }
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app['htmlmin'] = $this->app->share(function($app) {
            return new Classes\HTMLMin($app['view']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array('htmlmin');
    }
}
