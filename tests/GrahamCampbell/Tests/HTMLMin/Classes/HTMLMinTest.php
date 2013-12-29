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

namespace GrahamCampbell\Tests\HTMLMin\Classes;

use Mockery;
use PHPUnit_Framework_TestCase;
use GrahamCampbell\HTMLMin\Classes\HTMLMin;

/**
 * This is the htmlmin test class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/develop/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class HTMLMinTest extends PHPUnit_Framework_TestCase
{
    public function testBlade()
    {
        // TODO
    }

    public function testRender()
    {
        // TODO
    }

    public function testMake()
    {
        // TODO
    }

    protected function getHTMLMin()
    {
        $view = Mockery::mock('Illuminate\View\Environment');
        $html = Mockery::mock('Minify_HTML');
        $css = Mockery::mock('Minify_CSS');
        $js = Mockery::mock('JSMin');

        return new HTMLMin($view, $html, $css, $js);
    }
}
