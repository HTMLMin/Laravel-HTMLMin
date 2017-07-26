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

use Illuminate\Contracts\Foundation\Application;

/**
 * This is the blade enabled test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class SkipMinificationTest extends AbstractFunctionalTestCase
{
    /**
     * Setup the application environment.
     *
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

    public function testNewSkipHMTL()
    {
        $this->app->view->addNamespace('stubs', realpath(__DIR__.'/stubs'));

        $actual = $this->app->view->make('stubs::skiptest')->render();

        $expected = file_get_contents(__DIR__.'/stubs/skiptest.txt');

        $this->assertSameIgnoreLineEndings($expected, $actual);
    }

    public function testMarkDown()
    {
        $this->app->view->addNamespace('stubs', realpath(__DIR__.'/stubs'));

        $actual = $this->app->view->make('stubs::skipmarkdown')->render();

        $expected = file_get_contents(__DIR__.'/stubs/skipmarkdown.txt');

        $this->assertSameIgnoreLineEndings($expected, $actual);
    }
}
