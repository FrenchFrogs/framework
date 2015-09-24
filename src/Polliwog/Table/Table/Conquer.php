<?php namespace FrenchFrogs\Polliwog\Table\Table;

use FrenchFrogs\Core;
use FrenchFrogs\Polliwog\Table\Column;
use FrenchFrogs\Polliwog\Table\Renderer;
use FrenchFrogs\Polliwog\Form\Element;
use InvalidArgumentException;


/**
 * Polliwog Table for conquer private template
 *
 * @see http://themeforest.net/item/conquer-responsive-admin-dashboard-template/3716838
 *
 * Class Conquer
 * @package FrenchFrogs\Polliwog\Table\Table
 */
class Conquer extends Table
{

    public function __construct()
    {
        call_user_func_array(['parent', '__construct'], func_get_args());
        $this->setRenderer(new Renderer\Conquer());
    }
}