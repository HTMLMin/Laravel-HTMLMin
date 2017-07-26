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

namespace HTMLMin\Tests\HTMLMin;

use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use HTMLMin\HTMLMin\Compilers\MinifyCompiler;
use HTMLMin\HTMLMin\HTMLMin;
use HTMLMin\HTMLMin\Minifiers\BladeMinifier;
use HTMLMin\HTMLMin\Minifiers\CssMinifier;
use HTMLMin\HTMLMin\Minifiers\HtmlMinifier;
use HTMLMin\HTMLMin\Minifiers\JsMinifier;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
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
