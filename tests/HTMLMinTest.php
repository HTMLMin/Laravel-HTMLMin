<?php

/*
 * This file is part of Laravel HTMLMin by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at http://bit.ly/UWsjkb.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\Tests\HTMLMin;

use GrahamCampbell\HTMLMin\HTMLMin;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Mockery;

/**
 * This is the htmlmin test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2013-2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md> Apache 2.0
 */
class HTMLMinTest extends AbstractTestBenchTestCase
{
    public function methodProvider()
    {
        return [
            ['blade', 'getBladeMinifier'],
            ['css', 'getCssMinifier'],
            ['js', 'getJsMinifier'],
            ['html', 'getHtmlMinifier'],
        ];
    }

    /**
     * @dataProvider methodProvider
     */
    public function testMethods($method, $class)
    {
        $htmlmin = $this->getHTMLMin();

        $htmlmin->$class()->shouldReceive('render')
            ->once()->andReturn('abc');

        $return = $htmlmin->$method('test');

        $this->assertSame('abc', $return);
    }

    public function testLiveError()
    {
        $htmlmin = $this->getHTMLMin();

        $response = 'hello';

        $return = $htmlmin->live($response);

        $this->assertSame($response, $return);
    }

    public function testLiveRedirect()
    {
        $htmlmin = $this->getHTMLMin();

        $content = 'http://example.com/';

        $response = new RedirectResponse($content);

        $return = $htmlmin->live($response);

        $this->assertSame($response, $return);
        $this->assertSame($content, $return->getTargetUrl());
    }

    public function testLiveJson()
    {
        $htmlmin = $this->getHTMLMin();

        $content = ['<p>123</p>        <p>123</p>'];

        $response = new Response($content);

        $return = $htmlmin->live($response);

        $this->assertSame($response, $return);
        $this->assertSame('["<p>123<\/p>        <p>123<\/p>"]', $return->getContent());
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

        $this->assertSame($response, $return);
        $this->assertSame('<p>123</p><p>123</p>', $return->getContent());
    }

    protected function getHTMLMin()
    {
        $blade = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\BladeMinifier');
        $css = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\CssMinifier');
        $js = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\JsMinifier');
        $html = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier');

        return new HTMLMin($blade, $css, $js, $html);
    }
}
