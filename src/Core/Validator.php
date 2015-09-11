<?php namespace FrenchFrogs\Core;


trait Validator
{

    /**
     * container
     *
     * @var \FrenchFrogs\Validator\Validator
     */
    protected $validator;


    /**
     * getter
     *
     * @return \FrenchFrogs\Validator\Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }


    /**
     * Setter
     *
     * @param \FrenchFrogs\Validator\Validator $validator
     * @return $this
     */
    public function setValidator(\FrenchFrogs\Validator\Validator $validator)
    {

        $this->validator = $validator;
        return $this;
    }

    /**
     * Renvoie tru si un validator est setté
     *
     * @return bool
     */
    public function hasValidator()
    {
        return isset($this->validator);
    }


    /**
     * Ajoute un validateur
     *
     * @param $index
     * @param null $method
     * @param array $params
     * @param null $message
     * @return $this
     */
    public function addValidator($index, $method = null, array $params = [], $message = null)
    {
        // ajout de la methode aux paramètre de la regle
        array_unshift($params, $method);
        array_unshift($params, $index);
        call_user_func_array([$this->getValidator(), 'addRule'], $params);

        // gestion de message
        if (!is_null($message)) {
            $this->getValidator()->addMessage($index, $message);
        }

        return $this;
    }


    /**
     * Validation de l'element
     *
     * @param $value
     * @return $this
     * @throws \Exception
     */
    public function valid($value)
    {
        $this->getValidator()->valid($value);
        return $this;
    }


    /**
     * Renvoie si l'element est valide
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->getValidator()->isValid();
    }


    /**
     * Renvoie les erreur formater en chaine de charactère
     *
     *
     * @return string
     */
    public function getErrorAsString()
    {
        return $this->getValidator()->getErrorAsString();
    }
}