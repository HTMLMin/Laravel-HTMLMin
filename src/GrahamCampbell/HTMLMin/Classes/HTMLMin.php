<?php namespace GrahamCampbell\HTMLMin\Classes;

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
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @license    Apache License
 * @copyright  Copyright 2013 Graham Campbell
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */

use Minify_HTML;
use Minify_CSS;
use JSMin;
use Illuminate\View\Environment;

class HTMLMin
{

    /**
     * The view instance.
     *
     * @var \Illuminate\View\Environment
     */
    protected $view;

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\View\Environment  $view
     * @return void
     */
    public function __construct(Environment $view)
    {
        $this->view = $view;
    }

    /**
     * Get the minified blade.
     *
     * @param  string  $value
     * @return string
     */
    public function blade($value)
    {
        if (
            !preg_match('/<(pre|textarea)/', $value) &&
            !preg_match('/<script[^\??>]*>[^<\/script>]/', $value) &&
            !preg_match('/value=("|\')(.*)([ ]{2,})(.*)("|\')/', $value)
        ) {
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
        $options = array(
            'cssMinifier' => function ($css) {
                return Minify_CSS::minify($css, array('preserveComments' => false));
            },
            'jsMinifier' => function ($js) {
                return JSMin::minify($js);
            },
            'jsCleanComments' => true
        );

        $value = Minify_HTML::minify($value, $options);

        return $value;
    }

    /**
     * Get the minified view.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return string
     */
    public function make($view, array $data = array(), array $mergeData = array(), $full = false)
    {
        $value = $this->blade($this->view->make($view, $data, $mergeData)->render());

        if ($full) {
            $value = $this->render($value);
        }

        return $value;
    }
}
