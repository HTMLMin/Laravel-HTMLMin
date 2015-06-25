<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\HTMLMin\Compilers;

use GrahamCampbell\HTMLMin\Compilers\MinifyCompiler;
use GrahamCampbell\HTMLMin\Minifiers\BladeMinifier;
use GrahamCampbell\TestBench\AbstractTestCase;
use Illuminate\Filesystem\Filesystem;
use Mockery;

/**
 * This is the minify compiler test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
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
        $blade = Mockery::mock(BladeMinifier::class);
        $files = Mockery::mock(Filesystem::class);
        $cachePath = __DIR__;

        return new MinifyCompiler($blade, $files, $cachePath);
    }
}
