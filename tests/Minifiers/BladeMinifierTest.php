<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\HTMLMin\Minifiers;

use GrahamCampbell\HTMLMin\Minifiers\BladeMinifier;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the blade minifier test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class BladeMinifierTest extends AbstractTestCase
{
    public function testRenderEnabled()
    {
        $blade = $this->getBladeMinifier();

        $return = $blade->render('test    123');

        $this->assertSame('test 123', $return);

        $return = $blade->render('test    <div></div>');

        $this->assertSame('test <div></div>', $return);
    }

    public function tagProvider()
    {
        return [
            ['textarea'],
            ['pre'],
            ['code'],
        ];
    }

    /**
     * @dataProvider tagProvider
     */
    public function testRenderHtmlDisabled($tag)
    {
        $blade = $this->getBladeMinifier();

        $return = $blade->render("test    <$tag></$tag>");

        $this->assertSame("test    <$tag></$tag>", $return);
    }

    public function testRenderCommentDisabled()
    {
        $blade = $this->getBladeMinifier();

        $return = $blade->render('test    <?php // foo');

        $this->assertSame('test    <?php // foo', $return);
    }

    /**
     * @dataProvider tagProvider
     */
    public function testRenderForced($tag)
    {
        $blade = $this->getBladeMinifier(true);

        $return = $blade->render("test    <$tag></$tag>");

        $this->assertSame("test <$tag></$tag>", $return);
    }

    protected function getBladeMinifier($force = false)
    {
        return new BladeMinifier($force);
    }
}
