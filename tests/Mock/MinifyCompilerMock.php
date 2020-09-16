<?php

namespace HTMLMin\Tests\HTMLMin\Mock;

use Illuminate\View\Compilers\BladeCompiler;

class MinifyCompilerMock extends BladeCompiler
{
    /**
     * @return MinifyCompilerMock
     */
    public static function newInstance()
    {
        $app = app();
        $cache = $app['config']['view.compiled'];

        return new self($app['files'], $cache);
    }

    /**
     * @param BladeCompiler $compiler
     *
     * @return array
     */
    public function getCompilerCustomDirectives(BladeCompiler $compiler)
    {
        return $compiler->customDirectives;
    }
}
