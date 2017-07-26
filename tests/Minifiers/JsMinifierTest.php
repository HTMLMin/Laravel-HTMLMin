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
use HTMLMin\HTMLMin\Minifiers\JsMinifier;

/**
 * This is the js minifier test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class JsMinifierTest extends AbstractTestCase
{
    public function testRender()
    {
        $js = $this->getJsMinifier();

        $return = $js->render('alert("foo");    alert("bar");');

        $this->assertSame('alert("foo");alert("bar");', $return);
    }

    protected function getJsMinifier()
    {
        return new JsMinifier();
    }
}
