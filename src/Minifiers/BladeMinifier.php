<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\HTMLMin\Minifiers;

/**
 * This is the blade minifier class.
 *
 * @author Graham Campbell <graham@alt-three.com>
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
     * Create a new instance.
     *
     * @param bool $force
     *
     * @return void
     */
    public function __construct($force, CssMinifier $css, JsMinifier $js)
    {
        $this->force = $force;
        $this->css = $css;
        $this->js = $js;
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
            preg_match_all("/<style[^>]+>(.+?)<\/style>/ims", $value, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $value = str_replace($match[0], sprintf('<style type="text/css">%s</style>', $this->css->render($match[1])), $value);
            }

            preg_match_all("/<script(?![^>]*\bsrc\s*=)[^>]*>(.+?)<\/script>/ims", $value, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $value = str_replace($match[0], sprintf('<script type="text/javascript">%s</script>', $this->js->render($match[1])), $value);
            }

            $replace = [
                '/<!--[^\[](.*?)[^\]]-->/s' => '',
                "/<\?php/"                  => '<?php ',
                "/[\r\n]\s+/"               => '',
                "/[\r\n]/"                  => '', // for specific cases
                "/\t/"                      => ' ',
                '/ +/'                      => ' ',
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

        return !$this->containsBadHtml($value) && !$this->containsBadComments($value);
    }

    /**
     * Does the code contain bad html?
     *
     * @param string $value
     *
     * @return bool
     */
    protected function containsBadHtml($value)
    {
        return preg_match('/<(code|pre|textarea)/', $value) ||
               /*preg_match('/<script[^\??>]*>[^<\/script>]/', $value) ||*/
               preg_match('/value=("|\')(.*)([ ]{2,})(.*)("|\')/', $value);
    }

    /**
     * Does the code contain bad comments?
     *
     * @param string $value
     *
     * @return bool
     */
    protected function containsBadComments($value)
    {
        foreach (token_get_all($value) as $token) {
            if (!is_array($token) || !isset($token[0]) || $token[0] !== T_COMMENT) {
                continue;
            }

            if (substr($token[1], 0, 2) === '//') {
                return true;
            }
        }

        return false;
    }
}
