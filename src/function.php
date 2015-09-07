<?php



/**
 * Génération d'une balise html
 *
 * @param $tag
 * @param array $attributes
 * @param string $content
 * @return string
 */
function html($tag, $attributes = [], $content = '')
{
    $autoclosed = [
        'area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input',
        'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr'
    ];

    // gestion des attributs
    foreach($attributes as $key => &$value) {
        $value = sprintf('%s="%s"', $key, str_replace('"','\"', $value)) . ' ';
    }
    $attributes = implode(' ', $attributes);


    return array_search($tag, $autoclosed) === false ? sprintf('<%s %s/>%s</%1$s>', $tag, $attributes, $content) : sprintf('<%s %s/>', $tag, $attributes);

}