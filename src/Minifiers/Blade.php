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

namespace GrahamCampbell\HTMLMin\Minifiers;

use GrahamCampbell\HTMLMin\Interfaces\MinifierInterface;

/**
 * This is the blade minifier class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class Blade implements MinifierInterface
{
    /**
     * Should minification be forcefully enabled.
     *
     * @var bool
     */
    protected $force;

    /**
     * Create a new instance.
     *
     * @param  bool  $force
     * @return void
     */
    public function __construct($force)
    {
        $this->force = $force;
    }

    /**
     * Get the minified value.
     *
     * @param  string  $value
     * @return string
     */
    public function render($value)
    {
        if ($this->shouldMinify($value)) {
            $replace = array(
                '/<!--[^\[](.*?)[^\]]-->/s' => '',
                "/<\?php/"    => '<?php ',
                "/\n([\S])/"  => ' $1',
                "/\r/"        => '',
                "/\n/"        => '',
                "/\t/"        => ' ',
                "/ +/"        => ' '
            );

            $value = preg_replace(array_keys($replace), array_values($replace), $value);
        }

        return $value;
    }

    /**
     * Determine if the blade should be minified.
     *
     * @param  string  $value
     * @return bool
     */
    protected function shouldMinify($value)
    {
        if ($this->force) {
            return true;
        } else {
            return (!preg_match('/<(pre|textarea)/', $value) &&
                !preg_match('/<script[^\??>]*>[^<\/script>]/', $value) &&
                !preg_match('/value=("|\')(.*)([ ]{2,})(.*)("|\')/', $value));
        }
    }
}
