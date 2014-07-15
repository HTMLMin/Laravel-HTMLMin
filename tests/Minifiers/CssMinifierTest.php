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

namespace GrahamCampbell\Tests\HTMLMin\Minifiers;

use GrahamCampbell\HTMLMin\Minifiers\CssMinifier;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the css minifier test class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class CssMinifierTest extends AbstractTestCase
{
    public function testRender()
    {
        $css = $this->getCssMinifier();

        $return = $css->render('body { font-family: arial; } h1 { text-align: center; }');

        $this->assertEquals('body{font-family:arial}h1{text-align:center}', $return);
    }

    protected function getCssMinifier()
    {
        return new CssMinifier();
    }
}
