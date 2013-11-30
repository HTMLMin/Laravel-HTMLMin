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

class HTMLMin {

    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * Get the minified blade.
     *
     * @param  string  $value
     * @return string
     */
    public function blade($value) {
        if (!preg_match('/<(pre|textarea)/', $value) && !preg_match('/<script[^\??>]*>[^<\/script>]/', $value) && !preg_match('/value=("|\')(.*)([ ]{2,})(.*)("|\')/', $value)) {
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
    public function render($value) {
        $options = array(
            'cssMinifier' => function($css) {
                $cssMin = new \CSSmin;
                $css = $cssMin->run($css);
                return $css;
            },
            'jsMinifier' => function($js) {
                $js = \JSMin::minify($js);
                return $js;
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
    public function make($view, array $data = array(), array $mergeData = array()) {
        $value = $this->render($this->app['view']->make($view, $data, $mergeData)->render());

        return $value;
    }
}
