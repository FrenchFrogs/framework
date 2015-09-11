<?php
/**
 * Render an HTML tag
 *
 * @param $tag
 * @param array $attributes
 * @param string $content
 * @return string
 */

if (!function_exists('html')) {
    function html($tag, $attributes = [], $content = '')
    {
        $autoclosed = [
            'area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input',
            'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr'
        ];

        // Attributes
        foreach ($attributes as $key => &$value) {
            $value = sprintf('%s="%s"', $key, str_replace('"', '\"', $value)) . ' ';
        }
        $attributes = implode(' ', $attributes);


        return array_search($tag, $autoclosed) === false ? sprintf('<%s %s/>%s</%1$s>', $tag, $attributes, $content) : sprintf('<%s %s/>', $tag, $attributes);

    }
}


/**
 * Debug => die function
 *
 * dd => debug die
 *
 *
 */
if (!function_exists('dd')) {

    function dd() {
        array_map(function($x) { !d($x); }, func_get_args());
        d(microtime(),'Stats execution');
        die;
    }
}