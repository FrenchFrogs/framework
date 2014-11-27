<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 20/10/14
 * Time: 13:17
 */

namespace FrenchFrogs\Jquery;
use Illuminate\Support\Facades\Facade;
use App;


class Jquery  extends Facade {


    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Jquery';
    }

    /**
     *
     * @param string $url
     * @param string $method
     * @return \FrenchFrogs\Form\Form
     */
    static public function addOnload($content)
    {
        return App::make('jqueryOnload')->add($content);
    }


    /**
     *
     * renvoie le contenu du js généré sur l'event onloaod de jqueryu
     *
     */
    static function onload()
    {
        return strval(App::make('jqueryOnload'));
    }
}