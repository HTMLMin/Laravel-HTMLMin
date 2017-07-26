<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Raza Mehdi <srmk@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HTMLMin\Tests\HTMLMin\Compilers;

use GrahamCampbell\TestBench\AbstractTestCase;
use HTMLMin\HTMLMin\Compilers\MinifyCompiler;
use HTMLMin\HTMLMin\Minifiers\BladeMinifier;
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

    public function testMinifyIgnored()
    {
        $blade = Mockery::mock(BladeMinifier::class);
        $files = Mockery::mock(Filesystem::class);

        $compiler = Mockery::mock(MinifyCompiler::class, [$blade, $files, __DIR__, ['stubs']])
            ->makePartial();

        $compiler->shouldReceive('getPath')
            ->andReturn('stubs/index.blade.php');

        $blade->shouldReceive('render')
            ->never();

        $html = 'test    test';
        $return = $compiler->compileMinify($html);

        $this->assertSame($html, $return);
    }

    public function testCompilers()
    {
        $compiler = $this->getCompiler();

        $compilers = $compiler->getCompilers();

        $this->assertInArray('Minify', $compilers);
    }

    protected function getCompiler($ignoredPaths = [])
    {
        $blade = Mockery::mock(BladeMinifier::class);
        $files = Mockery::mock(Filesystem::class);
        $cachePath = __DIR__;

        return new MinifyCompiler($blade, $files, $cachePath, $ignoredPaths);
    }
}
