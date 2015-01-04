<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\HTMLMin\Minifiers;

/**
 * This is the blade minifier class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 * @author Trevor Fitzgerald <fitztrev@gmail.com>
 */
class BladeMinifier implements MinifierInterface
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
     * @param bool $force
     *
     * @return void
     */
    public function __construct($force)
    {
        $this->force = $force;
    }

    /**
     * Get the minified value.
     *
     * All credit to Trevor Fitzgerald for the regex here.
     * See the original here: http://bit.ly/U7mv7a.
     *
     * @param string $value
     *
     * @return string
     */
    public function render($value)
    {
        if ($this->shouldMinify($value)) {
            $replace = [
                '/<!--[^\[](.*?)[^\]]-->/s' => '',
                "/<\?php/"                  => '<?php ',
                "/\n([\S])/"                => ' $1',
                "/\r/"                      => '',
                "/\n/"                      => '',
                "/\t/"                      => ' ',
                "/ +/"                      => ' ',
            ];

            $value = preg_replace(array_keys($replace), array_values($replace), $value);
        }

        return $value;
    }

    /**
     * Determine if the blade should be minified.
     *
     * @param string $value
     *
     * @return bool
     */
    protected function shouldMinify($value)
    {
        if ($this->force) {
            return true;
        }

        return (!preg_match('/<(code|pre|textarea)/', $value) &&
            !preg_match('/<script[^\??>]*>[^<\/script>]/', $value) &&
            !preg_match('/value=("|\')(.*)([ ]{2,})(.*)("|\')/', $value));
    }
}
