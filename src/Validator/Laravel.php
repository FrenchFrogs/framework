<?php namespace FrenchFrogs\Validator;


class Laravel extends Validator
{

    public function validate($k, $data)
    {

        // formatage des regles
        $rules = [];
        foreach($this->getAllRule() as $key => $value) {
            $rules[] = $key . (!empty($value) ? (':' .$value) : '');
        }
        $rules = implode('|', $rules);

        //Creation du validator laravel
        $validator = \Validator::make([$k =>  $data], [$k => $rules], $this->getAllMessage());

        //On valide le validator
        $validator->valid();

        //Si echec du validator on set les messages d'erreurs
        if ($validator->fails()) {
            $this->setError(array_values($validator->getMessageBag()->getMessages())[0]);
        }

    }
}