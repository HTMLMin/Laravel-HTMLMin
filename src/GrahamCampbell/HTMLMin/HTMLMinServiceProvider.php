<?php namespace GrahamCampbell\HTMLMin;

use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app['htmlmin'] = $this->app->share(function($app) {
            return new GrahamCampbell\HTMLMin\Classes\HTMLMin;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }
}
