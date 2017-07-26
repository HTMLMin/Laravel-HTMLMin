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

namespace HTMLMin\Tests\HTMLMin\Functional;

use HTMLMin\HTMLMin\Http\Middleware\MinifyMiddleware;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

/**
 * This is the live enabled test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class MiddlewareTest extends AbstractFunctionalTestCase
{
    /**
     * Setup the application environment.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->config->set('htmlmin.live', true);
    }

    public function testNewSetup()
    {
        $this->app->view->addNamespace('stubs', realpath(__DIR__.'/stubs'));

        $this->app->router->get('htmlmin-test-route', ['middleware' => MinifyMiddleware::class, function () {
            return Response::view('stubs::test');
        }]);

        $actual = $this->call('GET', 'htmlmin-test-route')->getContent();

        $expected = file_get_contents(__DIR__.'/stubs/live.txt');

        $this->assertSameIgnoreLineEndings($expected, $actual);
    }

    public function testRedirect()
    {
        $this->app->router->get('htmlmin-test-route', ['middleware' => MinifyMiddleware::class, function () {
            return Redirect::to('foo');
        }]);

        $response = $this->call('GET', 'htmlmin-test-route');

        $this->assertSame($this->app->url->to('foo'), $response->headers->get('Location'));
    }

    public function testJson()
    {
        $this->app->router->get('htmlmin-test-route', ['middleware' => MinifyMiddleware::class, function () {
            return Response::json(['foo' => 'bar', ['baz']], 200, [], JSON_PRETTY_PRINT);
        }]);

        $actual = $this->call('GET', 'htmlmin-test-route')->getContent();

        $expected = file_get_contents(__DIR__.'/stubs/live.json');

        $this->assertSameIgnoreLineEndings($expected, $actual);
    }
}
