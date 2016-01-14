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
                //remove tabs before and after HTML tags
                '/\>[^\S ]+/s'   => '>',
                '/[^\S ]+\</s'   => '<',
                //shorten multiple whitespace sequences; keep new-line characters because they matter in JS!!!
                '/([\t ])+/s'  => ' ',
                //remove leading and trailing spaces
                '/^([\t ])+/m' => '',
                '/([\t ])+$/m' => '',
                // remove JS line comments (simple only); do NOT remove lines containing URL (e.g. 'src="http://server.com/"')!!!
                '~//[a-zA-Z0-9 ]+$~m' => '',
                //remove empty lines (sequence of line-end and white-space characters)
                '/[\r\n]+([\t ]?[\r\n]+)+/s'  => "\n",
                //remove empty lines (between HTML tags); cannot remove just any line-end characters because in inline JS they can matter!
                '/\>[\r\n\t ]+\</s'    => '><',
                //remove "empty" lines containing only JS's block end character; join with next line (e.g. "}\n}\n</script>" --> "}}</script>"
                '/}[\r\n\t ]+/s'  => '}',
                '/}[\r\n\t ]+,[\r\n\t ]+/s'  => '},',
                //remove new-line after JS's function or condition start; join with next line
                '/\)[\r\n\t ]?{[\r\n\t ]+/s'  => '){',
                '/,[\r\n\t ]?{[\r\n\t ]+/s'  => ',{',
                //remove new-line after JS's line end (only most obvious and safe cases)
                '/\),[\r\n\t ]+/s'  => '),',
                //remove quotes from HTML attributes that does not contain spaces; keep quotes around URLs!
                '~([\r\n\t ])?([a-zA-Z0-9]+)="([a-zA-Z0-9_/\\-]+)"([\r\n\t ])?~s' => '$1$2=$3$4', //$1 and $4 insert first white-space character found before/after attribute
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
