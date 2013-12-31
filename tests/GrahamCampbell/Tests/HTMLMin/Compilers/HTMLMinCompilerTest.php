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
use GrahamCampbell\HTMLMin\Compilers\HTMLMinCompiler;
use GrahamCampbell\TestBench\Classes\AbstractTestCase;

/**
 * This is the htmlmin compiler test class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/develop/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class HTMLMinCompilerTest extends AbstractTestCase
{
    public function testMinify()
    {
        $compiler = $this->getCompiler();

        $compiler->getHTMLMin()->shouldReceive('blade')->once()
            ->with('test')->andReturn('test');

        $return = $compiler->compileMinify('test');

        $this->assertEquals('test', $return);
    }

    public function testCompilers()
    {
        $compiler = $this->getCompiler();

        $compilers = $compiler->getCompilers();

        $this->assertInArray('Minify', $compilers);
    }

    protected function getCompiler()
    {
        $htmlmin = Mockery::mock('GrahamCampbell\HTMLMin\Classes\HTMLMin');
        $files = Mockery::mock('Illuminate\Filesystem\Filesystem');
        $cachePath = __DIR__;

        return new HTMLMinCompiler($htmlmin, $files, $cachePath);
    }
}
