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

/**
 * This is the blade enabled test class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class BladeEnabledTest extends AbstractFunctionalTestCase
{
    /**
     * Additional application environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function additionalSetup($app)
    {
        $app['config']->set('graham-campbell/htmlmin::blade', true);
    }

    public function testNewSetup()
    {
        $this->app['view']->addNamespace('stubs', realpath(__DIR__.'/stubs'));

        $actual = $this->app['view']->make('stubs::test')->render();

        $expected = file_get_contents(__DIR__.'/stubs/blade.txt');

        $this->assertSameIgnoreLineEndings($expected, $actual);
    }
}
