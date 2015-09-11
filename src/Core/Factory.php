<?php namespace FrenchFrogs\Core;

/**
 *
 * Main factory of the project
 *
 * Class Factory
 * @package FrenchFrogs\Core
 */
class Factory
{


    /**
     * Return a configured form
     *
     * @param string $url
     * @param string $method
     * @return \FrenchFrogs\Form\Form
     *
     */
    static public function form($url = '', $method = 'POST', \FrenchFrogs\Form\Renderer\FormAbstract $renderer = null, \FrenchFrogs\Validator\Validator $validator = null, \FrenchFrogs\Filterer\Filterer $filterer = null)
    {
        $form =  new \FrenchFrogs\Form\Form($url, $method);

        //renderer
        if (is_null($renderer)) {
            $renderer = new  \FrenchFrogs\Form\Renderer\Bootstrap();
        }
        $form->setRenderer($renderer);

        //Validator
        if (is_null($validator)) {
            $validator = new  \FrenchFrogs\Validator\DefaultValidator();
        }
        $form->setValidator($validator);


        //filterer
        if (is_null($filterer)) {
            $filterer = new  \FrenchFrogs\Filterer\Filterer();
        }
        $form->setFilterer($filterer);

        return $form;
    }
}