<?php

/**
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

namespace GrahamCampbell\Tests\HTMLMin\Functional;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

/**
 * This is the live enabled test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2013-2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md> Apache 2.0
 */
class LiveEnabledTest extends AbstractFunctionalTestCase
{
    /**
     * Additional application environment setup.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function additionalSetup($app)
    {
        $app['config']->set('graham-campbell/htmlmin::live', true);
    }

    public function testNewSetup()
    {
        $this->app['view']->addNamespace('stubs', realpath(__DIR__.'/stubs'));

        $this->app['router']->get('htmlmin-test-route', function () {
            return Response::view('stubs::test');
        });

        $actual = $this->call('GET', 'htmlmin-test-route')->getContent();

        $expected = file_get_contents(__DIR__.'/stubs/live.txt');

        $this->assertSameIgnoreLineEndings($expected, $actual);
    }

    public function testRedirect()
    {
        $this->app['router']->get('htmlmin-test-route', function () {
            return Redirect::to('foo');
        });

        $this->call('GET', 'htmlmin-test-route')->getContent();

        $this->assertRedirectedTo('foo');
    }

    public function testJson()
    {
        $this->app['router']->get('htmlmin-test-route', function () {
            return Response::json(['foo' => 'bar', ['baz']], 200, [], JSON_PRETTY_PRINT);
        });

        $actual = $this->call('GET', 'htmlmin-test-route')->getContent();

        $expected = file_get_contents(__DIR__.'/stubs/live.json');

        $this->assertSameIgnoreLineEndings($expected, $actual);
    }
}
