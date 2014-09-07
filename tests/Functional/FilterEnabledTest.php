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

/**
 * This is the filter enabled test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2013-2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md> Apache 2.0
 */
class FilterEnabledTest extends AbstractFunctionalTestCase
{
    /**
     * Specify if routing filters are enabled.
     *
     * @return bool
     */
    protected function enableFilters()
    {
        return true;
    }

    public function testNewSetup()
    {
        $this->app['view']->addNamespace('stubs', realpath(__DIR__.'/stubs'));

        $this->app['router']->get('htmlmin-test-route', array('after' => 'htmlmin', function () {
            return $this->app['view']->make('stubs::test');
        }));

        $actual = $this->call('GET', 'htmlmin-test-route')->getContent();

        $expected = file_get_contents(__DIR__.'/stubs/live.txt');

        $this->assertSameIgnoreLineEndings($expected, $actual);
    }
}
