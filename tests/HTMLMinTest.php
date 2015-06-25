<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\HTMLMin;

use GrahamCampbell\HTMLMin\HTMLMin;
use GrahamCampbell\HTMLMin\Minifiers\BladeMinifier;
use GrahamCampbell\HTMLMin\Minifiers\CssMinifier;
use GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier;
use GrahamCampbell\HTMLMin\Minifiers\JsMinifier;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use Mockery;

/**
 * This is the htmlmin test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class HTMLMinTest extends AbstractTestBenchTestCase
{
    public function methodProvider()
    {
        return [
            ['blade', 'getBladeMinifier'],
            ['css', 'getCssMinifier'],
            ['js', 'getJsMinifier'],
            ['html', 'getHtmlMinifier'],
        ];
    }

    /**
     * @dataProvider methodProvider
     */
    public function testMethods($method, $class)
    {
        $htmlmin = $this->getHTMLMin();

        $htmlmin->$class()->shouldReceive('render')
            ->once()->andReturn('abc');

        $return = $htmlmin->$method('test');

        $this->assertSame('abc', $return);
    }

    protected function getHTMLMin()
    {
        $blade = Mockery::mock(BladeMinifier::class);
        $css = Mockery::mock(CssMinifier::class);
        $js = Mockery::mock(JsMinifier::class);
        $html = Mockery::mock(HtmlMinifier::class);

        return new HTMLMin($blade, $css, $js, $html);
    }
}
