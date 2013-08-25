<?php namespace GrahamCampbell\HTMLMin\Classes;

class HTMLMin {

    /**
     * Get the minified html.
     *
     * @param  string  $render
     * @return string
     */
    public static function render($render) {
        $filters = array(
            '/<!--([^\[|(<!)].*)/' => '',
            '/(?<!\S)\/\/\s*[^\r\n]*/' => '',
            '/\s{2,}/' => '',
            '/(\r?\n)/' => '',
        );
        
        $render = preg_replace(array_keys($filters), array_values($filters), $render);

        return $render;
    }
}
