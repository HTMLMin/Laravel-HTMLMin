<?php

namespace HTMLMin\Tests\HTMLMin\Functional\Provider;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class TestDirectivesProvider extends ServiceProvider
{
    public static function testDirective()
    {
        return 'test content';
    }

    public function register()
    {
    }

    public function boot()
    {
        /** @var BladeCompiler $previousCompiler */
        $previousCompiler = $this->app->make('view')
            ->getEngineResolver()
            ->resolve('blade')
            ->getCompiler();

        $previousCompiler->directive('test_directive', [$this, 'testDirective']);
    }
}
