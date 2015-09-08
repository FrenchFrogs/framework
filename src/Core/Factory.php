<?php namespace FrenchFrogs\Core;


class Factory
{


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
            $validator = new  \FrenchFrogs\Validator\DefaultValidator();
        }
        $form->setValidator($validator);

        return $form;
    }

}