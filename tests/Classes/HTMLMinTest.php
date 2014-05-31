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
use GrahamCampbell\HTMLMin\Classes\HTMLMin;
use GrahamCampbell\TestBench\Classes\AbstractTestCase;

/**
 * This is the htmlmin test class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class HTMLMinTest extends AbstractTestCase
{
    public function testHtml()
    {
        $htmlmin = $this->getHTMLMin();

        $htmlmin->getHtml()->shouldReceive('render')
            ->once()->andReturn('abc');

        $return = $htmlmin->html('test');

        $this->assertEquals($return, 'abc');
    }

    public function testBlade()
    {
        $htmlmin = $this->getHTMLMin();

        $htmlmin->getBlade()->shouldReceive('render')
            ->once()->andReturn('abc');

        $return = $htmlmin->blade('test');

        $this->assertEquals($return, 'abc');
    }

    public function testLiveError()
    {
        $htmlmin = $this->getHTMLMin();

        $response = 'hello';

        $return = $htmlmin->live($response);

        $this->assertEquals($return, $response);
    }

    public function testLiveJson()
    {
        // TODO
    }

    public function testLiveHtml()
    {
        // TODO
    }

    public function testLiveMocked()
    {
        // TODO
    }

    protected function getHTMLMin()
    {
        $html = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\Html');
        $blade = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\Blade');

        return new HTMLMin($html, $blade);
    }
}
