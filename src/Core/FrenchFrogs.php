<?php namespace FrenchFrogs\Core;
use Illuminate\Support\Facades\Facade;



class FrenchFrogs extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'FrenchFrogs';
    }

    /**
     *
     * @param string $url
     * @param string $method
     * @return \FrenchFrogs\Form\Form
     *
     */
    static public function form($url = '', $method = 'POST')
    {
        return new \FrenchFrogs\Form\Form($url, $method);
    }
}
