<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\HTMLMin\Functional;

use GrahamCampbell\Tests\HTMLMin\AbstractTestCase;

/**
 * This is the abstract functional test case class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
abstract class AbstractFunctionalTestCase extends AbstractTestCase
{
    /**
     * Run extra setup code.
     *
     * @return void
     */
    protected function start()
    {
        $files = glob(storage_path('framework/views/*'));

        foreach ($files as $file) {
            @unlink($file);
        }
    }

    /**
     * Normalise eol characters in a string.
     *
     * @param string $string
     *
     * @return string
     */
    protected function normalize($string)
    {
        $string = str_replace("\r\n", "\n", $string);
        $string = str_replace("\r", "\n", $string);
        $string = preg_replace("/\n{2,}/", "\n\n", $string);

        return rtrim($string);
    }

    /**
     * Asserts that two variables have the same type and value.
     *
     * @param string $expected
     * @param string $actual
     * @param string $msg
     *
     * @return void
     */
    public function assertSameIgnoreLineEndings($expected, $actual, $msg = '')
    {
        $this->assertSame($this->normalize($expected), $this->normalize($actual), $msg);
    }
}
