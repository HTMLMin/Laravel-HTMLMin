<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\HTMLMin\Compilers;

use GrahamCampbell\HTMLMin\Compilers\MinifyCompiler;
use GrahamCampbell\TestBench\AbstractTestCase;
use Mockery;

/**
 * This is the minify compiler test class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class MinifyCompilerTest extends AbstractTestCase
{
    public function testMinify()
    {
        $compiler = $this->getCompiler();

        $compiler->getBladeMinifier()->shouldReceive('render')->once()
            ->with('test')->andReturn('abc');

        $return = $compiler->compileMinify('test');

        $this->assertSame('abc', $return);
    }

    public function testCompilers()
    {
        $compiler = $this->getCompiler();

        $compilers = $compiler->getCompilers();

        $this->assertInArray('Minify', $compilers);
    }

    protected function getCompiler()
    {
        $blade = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\BladeMinifier');
        $files = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $cachePath = __DIR__;

        return new MinifyCompiler($blade, $files, $cachePath);
    }
}
