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

namespace HTMLMin\HTMLMin\Minifiers;

use Minify_CSS;

/**
 * This is the css minifier class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CssMinifier implements MinifierInterface
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
        return Minify_CSS::minify($value, ['preserveComments' => false]);
    }
}
