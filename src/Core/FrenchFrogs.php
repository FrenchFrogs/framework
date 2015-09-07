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
    static public function form($url = '', $method = 'POST', \FrenchFrogs\Form\Renderer\FormAbstract $renderer = null, \FrenchFrogs\Validator\Validator $validator = null)
    {
        $form =  new \FrenchFrogs\Form\Form($url, $method);

        //On défini le renderer
        if (is_null($renderer)) {
            $renderer = new  \FrenchFrogs\Form\Renderer\Bootstrap();
        }
        $form->setRenderer($renderer);

        //On défini le validator
        if (is_null($validator)) {
            $validator = new  \FrenchFrogs\Validator\Validator();
        }
        $form->setValidator($validator);

        return $form;
    }
}
