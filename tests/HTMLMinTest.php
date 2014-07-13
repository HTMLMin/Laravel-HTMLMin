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

namespace GrahamCampbell\Tests\HTMLMin;

use Mockery;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use GrahamCampbell\HTMLMin\HTMLMin;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;

/**
 * This is the htmlmin test class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class HTMLMinTest extends AbstractTestBenchTestCase
{
    public function testHtml()
    {
        $htmlmin = $this->getHTMLMin();

        $htmlmin->getHtmlMinifier()->shouldReceive('render')
            ->once()->andReturn('abc');

        $return = $htmlmin->html('test');

        $this->assertEquals($return, 'abc');
    }

    public function testBlade()
    {
        $htmlmin = $this->getHTMLMin();

        $htmlmin->getBladeMinifier()->shouldReceive('render')
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

    public function testLiveRedirect()
    {
        $htmlmin = $this->getHTMLMin();

        $content = 'http://example.com/';

        $response = new RedirectResponse($content);

        $return = $htmlmin->live($response);

        $this->assertEquals($return, $response);
        $this->assertEquals($return->getTargetUrl(), $content);
    }

    public function testLiveJson()
    {
        $htmlmin = $this->getHTMLMin();

        $content = array('<p>123</p>        <p>123</p>');

        $response = new Response($content);

        $return = $htmlmin->live($response);

        $this->assertEquals($return, $response);
        $this->assertEquals($return->getContent(), '["<p>123<\/p>        <p>123<\/p>"]');
    }

    public function testLiveHtml()
    {
        $htmlmin = $this->getHTMLMin();

        $content = '<p>123</p>        <p>123</p>';

        $response = new Response($content);

        $response->headers->set('Content-Type', 'text/html');

        $htmlmin->getHtmlMinifier()->shouldReceive('render')->once()
            ->with($content)->andReturn('<p>123</p><p>123</p>');

        $return = $htmlmin->live($response);

        $this->assertEquals($return, $response);
        $this->assertEquals($return->getContent(), '<p>123</p><p>123</p>');
    }

    protected function getHTMLMin()
    {
        $html = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier');
        $blade = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\BladeMinifier');

        return new HTMLMin($html, $blade);
    }
}
