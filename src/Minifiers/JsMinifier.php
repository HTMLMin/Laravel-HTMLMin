<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\HTMLMin\Minifiers;

use JSMin;

/**
 * This is the js minifier class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class JsMinifier implements MinifierInterface
{
    /**
     * Get the minified value.
     *
     * @param string $value
     *
     * @return string
     */
    public function render($value)
    {
        return JSMin::minify($value);
    }
}
