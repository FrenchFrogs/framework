<?php

use FrenchFrogs\Core\Configurator;

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


        return array_search($tag, $autoclosed) === false ? sprintf('<%s %s>%s</%1$s>', $tag, $attributes, $content) : sprintf('<%s %s/>', $tag, $attributes);
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
 * Return human format octet size (mo, go etc...)
 *
 * @param unknown_type $size
 * @param unknown_type $round
 * @throws Exception
 */
function human_size($size, $round = 1) {

    $unit = array('Ko', 'Mo', 'Go', 'To');

    // initialisation du resultat
    $result = $size . 'o';

    // calcul
    foreach ($unit as $u) {if (($size /= 1024) > 1) {$result = round($size, $round) . $u;}}

    return $result;
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
 * @return FrenchFrogs\Panel\Panel\Panel
 */
function panel(...$args)
{
    // retrieve the good class
    $class = configurator()->get('panel.class', FrenchFrogs\Panel\Panel\Panel::class);

    // build the instance
    $reflection = new ReflectionClass($class);
    return $reflection->newInstanceArgs($args);
}

/**
 * Return new table polliwog instance
 *
 * @param ...$args
 * @return FrenchFrogs\Table\Table\Table
 */
function table(...$args)
{
    // retrieve the good class
    $class = configurator()->get('table.class', FrenchFrogs\Table\Table\Table::class);

    // build the instance
    $reflection = new ReflectionClass($class);
    return $reflection->newInstanceArgs($args);
}

/**
 * Return a new form polliwog instance
 *
 * @param ...$args
 * @return  FrenchFrogs\Form\Form\Form
 */
function form(...$args)
{
    // retrieve the good class
    $class = configurator()->get('form.class', FrenchFrogs\Form\Form\Form::class);

    // build the instance
    $reflection = new ReflectionClass($class);
    return $reflection->newInstanceArgs($args);
}

/**
 * Return new modal polliwog
 *
 * @param ...$args
 * @return FrenchFrogs\modal\Modal\Modal
 */
function modal(...$args)
{
    // retrieve the good class
    $class = configurator()->get('modal.class', FrenchFrogs\Modal\Modal\Modal::class);

    // build the instance
    $reflection = new ReflectionClass($class);
    return $reflection->newInstanceArgs($args);
}

/**
 * Return a Javascript Container polliwog
 *
 * @param $namespace
 * @param null $selector
 * @param null $function
 * @param ...$params
 * @return \FrenchFrogs\Container\Javascript
 */
function js($namespace = null, $selector = null, $function = null, ...$params)
{
    /** @var $container FrenchFrogs\Container\Javascript */
    $container = FrenchFrogs\Container\Javascript::getInstance($namespace);

    if (!is_null($function)){
        array_unshift($params, $selector, $function);
        call_user_func_array([$container, 'appendJs'], $params);
    } elseif(!is_null($selector)) {
        $container->append($selector);
    }

    return $container;
}

/**
 * Return action form url
 *
 * @param $controller
 * @param string $action
 * @param array $params
 * @return string
 */
function action_url($controller, $action = 'getIndex', $params = [])
{
    $controller = substr($controller, 0,3) == 'App' ?  '\\' . $controller : $controller;
    return URL::action($controller . '@' . $action, $params);
}


/**
 * Return ruler polliwog
 *
 * @return \FrenchFrogs\Ruler\Ruler\Container
 */
function ruler()
{
    // retrieve the good class
    $class = configurator()->get('ruler.class', FrenchFrogs\Ruler\Ruler\Ruler::class);

    return $class::getInstance();
}

/**
 *
 *
 * @param array ...$params
 * @return \Illuminate\Database\Query\Expression
 */
function raw(...$params) {
    return DB::raw(...$params);
}