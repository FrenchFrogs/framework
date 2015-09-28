<?php

use FrenchFrogs\Core\Configurator;
use FrenchFrogs\Polliwog;

if (!function_exists('html')) {
    /**
     * Render an HTML tag
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

    function dd()
    {
        array_map(function($x) { !d($x); }, func_get_args());
        d(microtime(),'Stats execution');
        die;
    }
}

/**
 * Return the namespace configurator
 *
 * @param null $namespace
 * @return \FrenchFrogs\Core\Configurator
 */
function configurator($namespace = null)
{
    return Configurator::getInstance($namespace);
}


/**
 * Return new panel polliwog instance
 *
 * @param ...$args
 * @return Polliwog\Panel\Panel\Panel
 */
function panel(...$args)
{

    // retrieve the good class
    $class = configurator()->get('panel.class', Polliwog\Panel\Panel\Panel::class);

    // build the instance
    $reflection = new ReflectionClass($class);
    return $reflection->newInstanceArgs($args);
}

/**
 * Return new table polliwog instance
 *
 * @param ...$args
 * @return Polliwog\Table\Table\Table
 */
function table(...$args)
{
    // retrieve the good class
    $class = configurator()->get('table.class', Polliwog\Table\Table\Table::class);

    // build the instance
    $reflection = new ReflectionClass($class);
    return $reflection->newInstanceArgs($args);
}

function modal(...$args)
{
    // retrieve the good class
    $class = configurator()->get('modal.class', Polliwog\Modal\Modal\Modal::class);

    // build the instance
    $reflection = new ReflectionClass($class);
    return $reflection->newInstanceArgs($args);
}
