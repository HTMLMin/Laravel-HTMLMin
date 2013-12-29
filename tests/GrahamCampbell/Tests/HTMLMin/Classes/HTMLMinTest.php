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
    public function testBladeEnabled()
    {
        $htmlmin = $this->getHTMLMin();

        $return = $htmlmin->blade('test   ');

        $this->assertEquals($return, 'test');

        $return = $htmlmin->blade('<div></div>test   ');

        $this->assertEquals($return, '<div></div>test');
    }

    public function testBladeDisabled()
    {
        $htmlmin = $this->getHTMLMin();

        $return = $htmlmin->blade('<textarea></textarea>test   ');

        $this->assertEquals($return, '<textarea></textarea>test   ');

        $return = $htmlmin->blade('<pre></pre>test   ');

        $this->assertEquals($return, '<pre></pre>test   ');
    }

    public function testRender()
    {
        $htmlmin = $this->getHTMLMin();

        $htmlmin->getHTML()->shouldReceive('render')->once()
            ->with('test', Mockery::type('array'))->andReturn('test');

        $return = $htmlmin->render('test');

        $this->assertEquals($return, 'test');
    }

    public function testMakeQuick()
    {
        $htmlmin = $this->getHTMLMin();

        $view = Mockery::mock('Illuminate\View\View');

        $view->shouldReceive('render')->once()->andReturn('test');

        $htmlmin->getView()->shouldReceive('make')->once()
            ->with('test', array('example' => 'qwerty'))->andReturn($view);

        $return = $htmlmin->make('test', array('example' => 'qwerty'));

        $this->assertEquals($return, 'test');
    }

    public function testMakeFull()
    {
        $htmlmin = $this->getHTMLMin();
        
        $view = Mockery::mock('Illuminate\View\View');

        $view->shouldReceive('render')->once()->andReturn('test');

        $htmlmin->getView()->shouldReceive('make')->once()
            ->with('test', array('example' => 'qwerty'))->andReturn($view);

        $htmlmin->getHTML()->shouldReceive('render')->once()
            ->with('test', Mockery::type('array'))->andReturn('test');

        $return = $htmlmin->make('test', array('example' => 'qwerty'), true);

        $this->assertEquals($return, 'test');
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
