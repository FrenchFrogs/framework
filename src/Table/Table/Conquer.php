<?php namespace FrenchFrogs\Table\Table;

use FrenchFrogs\Core;
use FrenchFrogs\Table\Column;
use FrenchFrogs\Table\Renderer;
use FrenchFrogs\Form\Element;
use InvalidArgumentException;


/**
 * Polliwog Table for conquer private template
 *
 * @see http://themeforest.net/item/conquer-responsive-admin-dashboard-template/3716838
 *
 * Class Conquer
 * @package FrenchFrogs\Table\Table
 */
class Conquer extends Table
{

    public function __construct()
    {
        call_user_func_array(['parent', '__construct'], func_get_args());
        $this->setRenderer(new Renderer\Conquer());
    }
}