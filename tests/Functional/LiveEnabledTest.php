<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\HTMLMin\Functional;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

/**
 * This is the live enabled test class.
 *
 * @author Graham Campbell <graham@mineuk.com>
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
