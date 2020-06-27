<?php

namespace HTMLMin\Tests\HTMLMin\Functional\Provider;

use HTMLMin\Tests\HTMLMin\Mock\ViewComponentMock;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class TestComponentsProvider extends ServiceProvider
{
    public function register()
    {
        config(['htmlmin.blade' => true]);
    }

    public function boot()
    {
        /** @var BladeCompiler $previousCompiler */
        $previousCompiler = $this->app->make('view')
            ->getEngineResolver()
            ->resolve('blade')
            ->getCompiler();

        if (version_compare($this->app->version(), '7.0', '>=')) {
            $previousCompiler->component(ViewComponentMock::class, 'test-component');
        }
    }
}
