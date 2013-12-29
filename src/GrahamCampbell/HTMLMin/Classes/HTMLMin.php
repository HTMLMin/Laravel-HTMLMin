<?php

/**
 * This file is part of Laravel HTMLMin by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\HTMLMin\Classes;

use Minify_HTML as HTML;
use Minify_CSS as CSS;
use JSMin as JS;
use Illuminate\View\Environment;

/**
 * This is the htmlmin class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/develop/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class HTMLMin
{
    /**
     * The view instance.
     *
     * @var \Illuminate\View\Environment
     */
    protected $view;

    /**
     * The html instance.
     *
     * @var \Minify_HTML
     */
    protected $html;

    /**
     * The css instance.
     *
     * @var \Minify_CSS
     */
    protected $css;

    /**
     * The js instance.
     *
     * @var \JSMin
     */
    protected $js;

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\View\Environment  $view
     * @param  \Minify_HTML  $html
     * @param  \Minify_CSS  $css
     * @param  \JSMin  $js
     * @return void
     */
    public function __construct(Environment $view, HTML $html, CSS $css, JS $js)
    {
        $this->view = $view;
        $this->html = $html;
        $this->css = $css;
        $this->js = $js;
    }

    /**
     * Get the minified blade.
     *
     * @param  string  $value
     * @return string
     */
    public function blade($value)
    {
        if (!preg_match('/<(pre|textarea)/', $value) &&
            !preg_match('/<script[^\??>]*>[^<\/script>]/', $value) &&
            !preg_match('/value=("|\')(.*)([ ]{2,})(.*)("|\')/', $value)) {
            $replace = array(
                '/<!--[^\[](.*?)[^\]]-->/s' => '',
                "/<\?php/" => '<?php ',
                "/\n/" => '',
                "/\r/" => '',
                "/\t/" => ' ',
                "/ +/" => ' '
            );
            $value = preg_replace(array_keys($replace), array_values($replace), $value);
        }

        return $value;
    }

    /**
     * Get the minified html.
     *
     * @param  string  $value
     * @return string
     */
    public function render($value)
    {
        $cssmin = $this->css;
        $jsmin = $this->css;

        $options = array(
            'cssMinifier' => function ($css) use ($cssmin) {
                return $cssmin->minify($css, array('preserveComments' => false));
            },
            'jsMinifier' => function ($js) use ($jsmin) {
                return $jsmin->minify($js);
            },
            'jsCleanComments' => true
        );

        $value = $this->html->minify($value, $options);

        return $value;
    }

    /**
     * Get the minified view.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  bool    $full
     * @return string
     */
    public function make($view, array $data = array(), $full = false)
    {
        $value = $this->blade($this->view->make($view, $data)->render());

        if ($full) {
            $value = $this->render($value);
        }

        return $value;
    }

    /**
     * Return the view instance.
     *
     * @return \Illuminate\View\Environment
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Return the html instance.
     *
     * @return \Minify_HTML
     */
    public function getHTML()
    {
        return $this->html;
    }

    /**
     * Return the css instance.
     *
     * @return \Minify_CSS
     */
    public function getCSS()
    {
        return $this->css;
    }

    /**
     * Return the js instance.
     *
     * @return \JSMin
     */
    public function getJS()
    {
        return $this->js;
    }
}
