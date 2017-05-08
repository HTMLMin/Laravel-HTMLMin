<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\HTMLMin\Functional;

use Illuminate\Contracts\Foundation\Application;

/**
 * This is the blade enabled test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class TextareaTest extends AbstractFunctionalTestCase
{
    /**
     * Setup the application environment.
     * Ensure that blade is on.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->config->set('htmlmin.blade', true);
    }

    public function testTextareaAndMore()
    {
        $this->app->view->addNamespace('stubs', realpath(__DIR__.'/stubs'));

        $actual = $this->app->view->make('stubs::textarea')->render();

        $expected = file_get_contents(__DIR__.'/stubs/textarea.txt');

        $this->assertSameIgnoreLineEndings($expected, $actual);
    }
}
