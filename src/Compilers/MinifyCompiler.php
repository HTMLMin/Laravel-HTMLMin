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
     * @var \Illuminate\View\Compilers\BladeCompiler|null
     */
    private $previousCompiler;

    /**
     * Create a new instance.
     *
     * @param \HTMLMin\HTMLMin\Minifiers\BladeMinifier $blade
     * @param \Illuminate\Filesystem\Filesystem        $files
     * @param string                                   $cachePath
     * @param array                                    $ignoredPaths
     * @param \Illuminate\View\Compilers\BladeCompiler $previousCompiler
     *
     * @return void
     */
    public function __construct(
        BladeMinifier $blade,
        Filesystem $files,
        $cachePath,
        $ignoredPaths = [],
        $previousCompiler = null
    ) {
        parent::__construct($files, $cachePath);
        $this->blade = $blade;
        $this->ignoredPaths = $ignoredPaths;
        $this->compilers[] = 'Minify';
        $this->previousCompiler = $previousCompiler;
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

    /**
     * @return void
     */
    public function initMinifyCompiler()
    {
        if ($this->previousCompiler === null) {
            return;
        }

        if (property_exists($this->previousCompiler, 'customDirectives')) {
            foreach ($this->previousCompiler->customDirectives as $name => $handler) {
                $this->directive($name, $handler);
            }
        }

        if (property_exists($this->previousCompiler, 'classComponentAliases')) {
            foreach ($this->previousCompiler->classComponentAliases as $name => $handler) {
                $this->component($handler, $name);
            }
        }
    }
}
