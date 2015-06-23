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

use GrahamCampbell\HTMLMin\Compilers\MinifyCompiler;
use GrahamCampbell\HTMLMin\HTMLMin;
use GrahamCampbell\HTMLMin\Minifiers\BladeMinifier;
use GrahamCampbell\HTMLMin\Minifiers\CssMinifier;
use GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier;
use GrahamCampbell\HTMLMin\Minifiers\JsMinifier;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testCssMinifierIsInjectable()
    {
        $this->assertIsInjectable(CssMinifier::class);
    }

    public function testJsMinifierIsInjectable()
    {
        $this->assertIsInjectable(JsMinifier::class);
    }

    public function testHtmlMinifierIsInjectable()
    {
        $this->assertIsInjectable(HtmlMinifier::class);
    }

    public function testBladeMinifierIsInjectable()
    {
        $this->assertIsInjectable(BladeMinifier::class);
    }

    public function testCompilerIsInjectable()
    {
        $this->assertIsInjectable(MinifyCompiler::class);
    }

    public function testHTMLMinIsInjectable()
    {
        $this->assertIsInjectable(HTMLMin::class);
    }
}
