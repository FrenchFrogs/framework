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
     * @return \FrenchFrogs\Polliwog\Form\Form
     *
     */
    static public function form($url = '', $method = 'POST', \FrenchFrogs\Polliwog\Form\Renderer\FormAbstract $renderer = null, \FrenchFrogs\Model\Validator\Validator $validator = null, \FrenchFrogs\Model\Filterer\Filterer $filterer = null)
    {
        $form =  new \FrenchFrogs\Polliwog\Form\Form($url, $method);

        //renderer
        if (is_null($renderer)) {
            $renderer = new  \FrenchFrogs\Polliwog\Form\Renderer\Bootstrap();
        }
        $form->setRenderer($renderer);

        //Validator
        if (is_null($validator)) {
            $validator = new  \FrenchFrogs\Model\Validator\Validator();
        }
        $form->setValidator($validator);


        //filterer
        if (is_null($filterer)) {
            $filterer = new  \FrenchFrogs\Model\Filterer\Filterer();
        }
        $form->setFilterer($filterer);

        return $form;
    }
}