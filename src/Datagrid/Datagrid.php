<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 20/10/14
 * Time: 16:24
 */

namespace FrenchFrogs\Datagrid;
use FrenchFrogs\Core\HtmlTag;
use Illuminate\Pagination\Paginator;

class Datagrid
{

    use HtmlTag;

    /**
     *
     *
     * @var Paginator
     */
    protected $paginator;


    /**
     * adapter
     *
     * @var
     */
    protected $adapter;


    /**
     *
     * Constructeur
     *
     */
    public function __construct($adapter)
    {
        $this->adapter = $adapter;
    }



    /**
     *
     *
     * @return $this
     */
    static public function make()
    {

        if (method_exists(static::$class, 'init')) {
            $instance = call_user_func_array([static::$class, 'init'], func_get_args());
        } else {
            $instance = new static::$class(func_get_arg(0));
        }

        return $instance;
    }





    /**
     *
     *
     * @return string
     */
    public function __toString()
    {

        dd('//@todo');
        return '';

    }

} 