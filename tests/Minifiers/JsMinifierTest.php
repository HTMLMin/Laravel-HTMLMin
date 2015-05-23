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

use GrahamCampbell\HTMLMin\Minifiers\JsMinifier;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the js minifier test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
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
