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

namespace GrahamCampbell\HTMLMin;

use GrahamCampbell\HTMLMin\Minifiers\BladeMinifier;
use GrahamCampbell\HTMLMin\Minifiers\CssMinifier;
use GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier;
use GrahamCampbell\HTMLMin\Minifiers\JsMinifier;
use Illuminate\Http\Response;

/**
 * This is the htmlmin class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2013-2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md> Apache 2.0
 */
class HTMLMin
{
    /**
     * The blade minifier instance.
     *
     * @var \GrahamCampbell\HTMLMin\Minifiers\BladeMinifier
     */
    protected $blade;

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
     * The html minifier instance.
     *
     * @var \GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier
     */
    protected $html;

    /**
     * Create a new instance.
     *
     * @param \GrahamCampbell\HTMLMin\Minifiers\BladeMinifier $blade
     * @param \GrahamCampbell\HTMLMin\Minifiers\CssMinifier   $css
     * @param \GrahamCampbell\HTMLMin\Minifiers\JsMinifier    $js
     * @param \GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier  $html
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
     * Get the minified response.
     *
     * @param mixed $response
     *
     * @return mixed
     */
    public function live($response)
    {
        if ($this->isAResponseObject($response) && $this->isAnHtmlResponse($response)) {
            $output = $response->getContent();
            $minified = $this->html->render($output);
            $response->setContent($minified);
        }

        return $response;
    }

    /**
     * Check if the response is a usable response class.
     *
     * @param mixed $response
     *
     * @return bool
     */
    protected function isAResponseObject($response)
    {
        return (is_object($response) && $response instanceof Response);
    }

    /**
     * Check if the content type header is html.
     *
     * @param \Illuminate\Http\Response $response
     *
     * @return bool
     */
    protected function isAnHtmlResponse(Response $response)
    {
        return (strpos($response->headers->get('Content-Type'), 'text/html') !== false);
    }

    /**
     * Return the blade minifier instance.
     *
     * @return \GrahamCampbell\HTMLMin\Minifiers\BladeMinifier
     */
    public function getBladeMinifier()
    {
        return $this->blade;
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

    /**
     * Return the html minifier instance.
     *
     * @return \GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier
     */
    public function getHtmlMinifier()
    {
        return $this->html;
    }
}
