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

namespace GrahamCampbell\HTMLMin\Compilers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use GrahamCampbell\HTMLMin\Minifiers\BladeMinifier;

/**
 * This is the minify compiler class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class MinifyCompiler extends BladeCompiler
{
    /**
     * The blade minifier instance.
     *
     * @var \GrahamCampbell\HTMLMin\Minifiers\BladeMinifier
     */
    protected $blade;

    /**
     * Create a new instance.
     *
     * @param  \GrahamCampbell\HTMLMin\Minifiers\BladeMinifier  $blade
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $cachePath
     * @return void
     */
    public function __construct(BladeMinifier $blade, Filesystem $files, $cachePath)
    {
        parent::__construct($files, $cachePath);
        $this->blade = $blade;
        $this->compilers[] = 'Minify';
    }

    /**
    * Minifies the output before saving it.
    *
    * @param  string  $value
    * @return string
    */
    public function compileMinify($value)
    {
        return $this->blade->render($value);
    }

    /**
     * Return the compilers.
     *
     * @return array
     */
    public function getCompilers()
    {
        return $this->compilers;
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
