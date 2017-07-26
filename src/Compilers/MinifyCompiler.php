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

namespace HTMLMin\HTMLMin\Compilers;

use HTMLMin\HTMLMin\Minifiers\BladeMinifier;
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
     * @var \HTMLMin\HTMLMin\Minifiers\BladeMinifier
     */
    protected $blade;

    /**
     * The ignored paths.
     *
     * @var string
     */
    protected $ignoredPaths;

    /**
     * Create a new instance.
     *
     * @param \HTMLMin\HTMLMin\Minifiers\BladeMinifier $blade
     * @param \Illuminate\Filesystem\Filesystem        $files
     * @param string                                   $cachePath
     * @param array                                    $ignoredPaths
     *
     * @return void
     */
    public function __construct(BladeMinifier $blade, Filesystem $files, $cachePath, $ignoredPaths = [])
    {
        parent::__construct($files, $cachePath);
        $this->blade = $blade;
        $this->ignoredPaths = $ignoredPaths;
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
        if ($this->ignoredPaths) {
            $path = str_replace('\\', '/', $this->getPath());

            foreach ($this->ignoredPaths as $ignoredPath) {
                if (strpos($path, $ignoredPath) !== false) {
                    return $value;
                }
            }
        }

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
     * @return \HTMLMin\HTMLMin\Minifiers\BladeMinifier
     */
    public function getBladeMinifier()
    {
        return $this->blade;
    }
}
