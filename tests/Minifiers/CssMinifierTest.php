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

namespace HTMLMin\Tests\HTMLMin\Minifiers;

use GrahamCampbell\TestBench\AbstractTestCase;
use HTMLMin\HTMLMin\Minifiers\CssMinifier;

/**
 * This is the css minifier test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CssMinifierTest extends AbstractTestCase
{
    public function testRender()
    {
        $css = $this->getCssMinifier();

        $return = $css->render('body { font-family: arial; } h1 { text-align: center; }');

        $this->assertSame('body{font-family:arial}h1{text-align:center}', $return);
    }

    protected function getCssMinifier()
    {
        return new CssMinifier();
    }
}
