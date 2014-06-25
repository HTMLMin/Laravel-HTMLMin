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

namespace GrahamCampbell\Tests\HTMLMin\Compilers;

use Mockery;
use GrahamCampbell\HTMLMin\Compilers\MinifyCompiler;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the minify compiler test class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class MinifyCompilerTest extends AbstractTestCase
{
    public function testMinify()
    {
        $compiler = $this->getCompiler();

        $compiler->getBlade()->shouldReceive('render')->once()
            ->with('test')->andReturn('abc');

        $return = $compiler->compileMinify('test');

        $this->assertEquals('abc', $return);
    }

    public function testCompilers()
    {
        $compiler = $this->getCompiler();

        $compilers = $compiler->getCompilers();

        $this->assertInArray('Minify', $compilers);
    }

    protected function getCompiler()
    {
        $blade = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\Blade');
        $files = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $cachePath = __DIR__;

        return new MinifyCompiler($blade, $files, $cachePath);
    }
}
