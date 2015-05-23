<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\HTMLMin\Minifiers;

use GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier;
use GrahamCampbell\TestBench\AbstractTestCase;
use Mockery;

/**
 * This is the html minifier test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class HtmlMinifierTest extends AbstractTestCase
{
    public function testRenderQuick()
    {
        $html = $this->getHtmlMinifier();

        $return = $html->render('test');

        $this->assertSame('test', $return);
    }

    public function testRenderFull()
    {
        $html = $this->getHtmlMinifier();
        $text = 'test<style>font-size: 12pt;</style><script>alert("Hello");</script>';

        $html->getCssMinifier()->shouldReceive('render')->once()
            ->with('font-size: 12pt;')->andReturn('foo');

        $html->getJsMinifier()->shouldReceive('render')->once()
            ->with('alert("Hello");')->andReturn('bar');

        $return = $html->render($text);

        $this->assertSame('test<style>foo</style><script>bar</script>', $return);
    }

    protected function getHtmlMinifier()
    {
        $css = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\CssMinifier');
        $js = Mockery::mock('GrahamCampbell\HTMLMin\Minifiers\JsMinifier');

        return new HtmlMinifier($css, $js);
    }
}
