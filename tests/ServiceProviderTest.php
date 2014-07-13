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

use GrahamCampbell\TestBench\Traits\ServiceProviderTestCaseTrait;

/**
 * This is the service provider test class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTestCaseTrait;

    public function testHtmlMinifierIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier');
    }

    public function testBladeMinifierIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\HTMLMin\Minifiers\BladeMinifier');
    }

    public function testCompilerIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\HTMLMin\Compilers\MinifyCompiler');
    }

    public function testHTMLMinIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\HTMLMin\HTMLMin');
    }
}
