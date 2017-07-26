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

namespace HTMLMin\HTMLMin;

use HTMLMin\HTMLMin\Minifiers\BladeMinifier;
use HTMLMin\HTMLMin\Minifiers\CssMinifier;
use HTMLMin\HTMLMin\Minifiers\HtmlMinifier;
use HTMLMin\HTMLMin\Minifiers\JsMinifier;

/**
 * This is the htmlmin class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class HTMLMin
{
    /**
     * The blade minifier instance.
     *
     * @var \HTMLMin\HTMLMin\Minifiers\BladeMinifier
     */
    protected $blade;

    /**
     * The css minifier instance.
     *
     * @var \HTMLMin\HTMLMin\Minifiers\CssMinifier
     */
    protected $css;

    /**
     * The js minifier instance.
     *
     * @var \HTMLMin\HTMLMin\Minifiers\JsMinifier
     */
    protected $js;

    /**
     * The html minifier instance.
     *
     * @var \HTMLMin\HTMLMin\Minifiers\HtmlMinifier
     */
    protected $html;

    /**
     * Create a new instance.
     *
     * @param \HTMLMin\HTMLMin\Minifiers\BladeMinifier $blade
     * @param \HTMLMin\HTMLMin\Minifiers\CssMinifier   $css
     * @param \HTMLMin\HTMLMin\Minifiers\JsMinifier    $js
     * @param \HTMLMin\HTMLMin\Minifiers\HtmlMinifier  $html
     *
     * @return void
     */
    public function __construct(BladeMinifier $blade, CssMinifier $css, JsMinifier $js, HtmlMinifier $html)
    {
        $this->blade = $blade;
        $this->css = $css;
        $this->js = $js;
        $this->html = $html;
    }

    /**
     * Get the minified blade.
     *
     * @param string $value
     *
     * @return string
     */
    public function blade($value)
    {
        return $this->blade->render($value);
    }

    /**
     * Get the minified css.
     *
     * @param string $value
     *
     * @return string
     */
    public function css($value)
    {
        return $this->css->render($value);
    }

    /**
     * Get the minified js.
     *
     * @param string $value
     *
     * @return string
     */
    public function js($value)
    {
        return $this->js->render($value);
    }

    /**
     * Get the minified html.
     *
     * @param string $value
     *
     * @return string
     */
    public function html($value)
    {
        return $this->html->render($value);
    }

    /**
     * Return the blade minifier instance.
     *
     * @return \HTMLMin\HTMLMin\Minifiers\BladeMinifier
     */
    public function getBladeMinifier()
    {
        return $this->blade;
    }

    /**
     * Return the css minifier instance.
     *
     * @return \HTMLMin\HTMLMin\Minifiers\CssMinifier
     */
    public function getCssMinifier()
    {
        return $this->css;
    }

    /**
     * Return the js minifier instance.
     *
     * @return \HTMLMin\HTMLMin\Minifiers\JsMinifier
     */
    public function getJsMinifier()
    {
        return $this->js;
    }

    /**
     * Return the html minifier instance.
     *
     * @return \HTMLMin\HTMLMin\Minifiers\HtmlMinifier
     */
    public function getHtmlMinifier()
    {
        return $this->html;
    }
}
