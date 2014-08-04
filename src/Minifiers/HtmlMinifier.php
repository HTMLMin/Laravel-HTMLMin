<?php

/**
 * This file is part of Laravel HTMLMin by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at http://bit.ly/UWsjkb.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\HTMLMin\Minifiers;

use Minify_HTML;

/**
 * This is the html minifier class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2013-2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md> Apache 2.0
 */
class HtmlMinifier implements MinifierInterface
{
    /**
     * The css minifier instance.
     *
     * @var \GrahamCampbell\HTMLMin\Minifiers\CssMinifier
     */
    protected $css;

    /**
     * The js minifier instance.
     *
     * @var \GrahamCampbell\HTMLMin\Minifiers\JsMinifier
     */
    protected $js;

    /**
     * Create a new instance.
     *
     * @param \GrahamCampbell\HTMLMin\Minifiers\CssMinifier $css
     * @param \GrahamCampbell\HTMLMin\Minifiers\JsMinifier  $js
     *
     * @return void
     */
    public function __construct(CssMinifier $css, JsMinifier $js)
    {
        $this->css = $css;
        $this->js = $js;
    }

    /**
     * Get the minified value.
     *
     * @param string $value
     *
     * @return string
     */
    public function render($value)
    {
        $options = array(
            'cssMinifier' => function ($css) {
                return $this->css->render($css);
            },
            'jsMinifier' => function ($js) {
                return $this->js->render($js);
            },
            'jsCleanComments' => true
        );

        return Minify_HTML::minify($value, $options);
    }

    /**
     * Return the css minifier instance.
     *
     * @return \GrahamCampbell\HTMLMin\Minifiers\CssMinifier
     */
    public function getCssMinifier()
    {
        return $this->css;
    }

    /**
     * Return the js minifier instance.
     *
     * @return \GrahamCampbell\HTMLMin\Minifiers\JsMinifier
     */
    public function getJsMinifier()
    {
        return $this->js;
    }
}
