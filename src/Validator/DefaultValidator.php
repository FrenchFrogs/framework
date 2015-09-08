<?php namespace FrenchFrogs\Validator;


class DefaultValidator extends Validator
{

    /**
     * Renvoie si false si aucune valeur n'est saisie
     *
     * @param $value
     * @return bool
     */
    public function required($value)
    {
        $this->addMessage('required', 'La valeur est obligatoire');

        if (is_null($value) || $value == '') {
            return false;
        }

        return true;
    }

    /**
     * Verifie si la la valeur match le pattern d'une url
     *
     * @param $value
     * @return bool
     */
    public function url($value)
    {
        $this->addMessage('url', 'La valeur \'%s\' n\'est pas une URL valide');
        return !(filter_var($value, FILTER_VALIDATE_URL) == false);
    }


    /**
     * Verifie si la la valeur match le pattern d'une ip
     *
     * @param $value
     * @return bool
     */
    public function ip($value)
    {
        $this->addMessage('email', 'La valeur \'%s\' n\'est pas une IP valide');
        return !(filter_var($value, FILTER_VALIDATE_IP) == false);
    }

    /**
     * Verifie si la la valeur match le pattern d'une ip
     *
     * @param $value
     * @return bool
     */
    public function email($value)
    {
        $this->addMessage('email', 'La valeur \'%s\' n\'est pas un email valide');
        return !(filter_var($value, FILTER_VALIDATE_EMAIL) == false);
    }

    /**
     * Verifie si la la valeur match une regex
     *
     * @param $value
     * @return bool
     */
    public function regex($value, $pattern)
    {
        $this->addMessage('regex', 'La valeur \'%s\' ne match pas le pattern \'%s\'');
        return preg_match($pattern, $value);
    }


    /**
     * Verifie que la valeur existe dans le tableau
     *
     * @param $value
     * @param $array
     * @return bool
     */
    public function inArray($value, $array)
    {
        $this->addMessage('inArray', 'La valeur \'%s\' n\'est pas dans les valeurs attendues');
        return in_array($value, $array);
    }


}