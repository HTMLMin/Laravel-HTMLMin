<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\HTMLMin\Functional;

/**
 * This is the filter enabled test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class FilterEnabledTest extends AbstractFunctionalTestCase
{
    public function testNewSetup()
    {
        $this->app->view->addNamespace('stubs', realpath(__DIR__.'/stubs'));

        $this->app->router->get('htmlmin-test-route', ['after' => 'htmlmin', function () {
            return $this->app->view->make('stubs::test');
        }]);

        $actual = $this->call('GET', 'htmlmin-test-route')->getContent();

        $expected = file_get_contents(__DIR__.'/stubs/live.txt');

        $this->assertSameIgnoreLineEndings($expected, $actual);
    }
}
