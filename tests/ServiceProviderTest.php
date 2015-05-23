<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\HTMLMin;

use GrahamCampbell\TestBench\Traits\ServiceProviderTestCaseTrait;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTestCaseTrait;

    public function testCssMinifierIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\HTMLMin\Minifiers\CssMinifier');
    }

    public function testJsMinifierIsInjectable()
    {
        $this->assertIsInjectable('GrahamCampbell\HTMLMin\Minifiers\JsMinifier');
    }

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
