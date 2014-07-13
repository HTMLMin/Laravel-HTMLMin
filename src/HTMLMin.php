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

namespace GrahamCampbell\HTMLMin;

use Illuminate\Http\Response;
use GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier;
use GrahamCampbell\HTMLMin\Minifiers\BladeMinifier;

/**
 * This is the htmlmin class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class HTMLMin
{
    /**
     * The html minifier instance.
     *
     * @var \GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier
     */
    protected $html;

    /**
     * The blade minifier instance.
     *
     * @var \GrahamCampbell\HTMLMin\Minifiers\BladeMinifier
     */
    protected $blade;

    /**
     * Create a new instance.
     *
     * @param  \GrahamCampbell\HTMLMin\Minifiers\HtmlMinifier  $html
     * @param  \GrahamCampbell\HTMLMin\Minifiers\BladeMinifier  $blade
     * @return void
     */
    public function __construct(HtmlMinifier $html, BladeMinifier $blade)
    {
        $this->html = $html;
        $this->blade = $blade;
    }

    /**
     * Get the minified html.
     *
     * @param  string  $value
     * @return string
     */
    public function html($value)
    {
        return $this->html->render($value);
    }

    /**
     * Get the minified blade.
     *
     * @param  string  $value
     * @return string
     */
    public function blade($value)
    {
        return $this->blade->render($value);
    }

    /**
     * Get the minified response.
     *
     * @param  mixed  $response
     * @return mixed
     */
    public function live($response)
    {
        if ($response instanceof Response) {
            // check if the response has a content type header
            if ($response->headers->has('Content-Type') !== false) {
                // check if the contact type header is html
                if (strpos($response->headers->get('Content-Type'), 'text/html') !== false) {
                    // get the response body
                    $output = $response->getContent();
                    // minify the response body
                    $min = $this->html->render($output);
                    // set the response body
                    $response->setContent($min);
                }
            }
        }

        return $response;
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

    /**
     * Return the blade minifier instance.
     *
     * @return \GrahamCampbell\HTMLMin\Minifiers\BladeMinifier
     */
    public function getBladeMinifier()
    {
        return $this->blade;
    }
}
