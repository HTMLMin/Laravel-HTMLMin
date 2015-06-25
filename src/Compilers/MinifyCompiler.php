<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\HTMLMin\Compilers;

use GrahamCampbell\HTMLMin\Minifiers\BladeMinifier;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;

/**
 * This is the minify compiler class.
 *
 * @author Graham Campbell <graham@alt-three.com>
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
     * @param \GrahamCampbell\HTMLMin\Minifiers\BladeMinifier $blade
     * @param \Illuminate\Filesystem\Filesystem               $files
     * @param string                                          $cachePath
     *
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
     * @param string $value
     *
     * @return string
     */
    public function compileMinify($value)
    {
        return $this->blade->render($value);
    }

    /**
     * Return the compilers.
     *
     * @return string[]
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
