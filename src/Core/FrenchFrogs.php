<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 17/10/14
 * Time: 15:11
 */

namespace FrenchFrogs\Core;
use Illuminate\Support\Facades\Facade;



class FrenchFrogs extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor() { return 'frenchfrogs'; }

    /**
     *
     * @param string $url
     * @param string $method
     * @return \FrenchFrogs\Form\Form
     */
    static public function form($url = '', $method = 'POST')
    {
        return new \FrenchFrogs\Form\Form($url, $method);
    }
}
