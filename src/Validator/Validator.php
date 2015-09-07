<?php namespace FrenchFrogs\Validator;


class Validator
{

    /**
     * Regle de validation
     *
     * @var array
     */
    protected $rule = [];

    /**
     * Message
     *
     * @var array
     */
    protected $message = [];

    /**
     * Erreur
     *
     * @var array
     */
    protected $error = [];

    /**
     * Message d'erreur par default
     *
     */
    const MESSAGE_DEFAULT_PATTERN = 'Erreur sur la valeur %s';

    /**
     * Constructeur
     *
     * @param ...$params
     */
    public function __construct(...$params)
    {
        // s'il y a  une methode pour enregistrer des
        if (method_exists($this, 'init')) {
            call_user_func_array([$this, 'init'], $params);
        }
    }

    /**
     * Set des rule
     *
     * @param array $rule
     * @return $this
     */
    public function setRule(array $rule)
    {
        $this->rule = $rule;
        return $this;
    }

    /**
     * Ajoute un Regle
     *
     * @param $index
     * @param $rule
     * @return $this
     */
    public function addRule($index, $method = null, ...$params)
    {
        $this->rule[$index] = [$method, $params];
        return $this;
    }

    /**
     * Suppression d'une règle
     *
     * @param $index
     * @return $this
     */
    public function removeRule($index)
    {
        if ($this->hasRule($index)) {
            unset($this->rule[$index]);
        }

        return $this;
    }

    /**
     * Efface toutes les reègles
     *notempty
     * @return $this
     */
    public function clearRule()
    {
        $this->rule = [];

        return $this;
    }

    /**
     * Renvoie true si la règle existe
     *
     * @param $index
     * @return bool
     */
    public function hasRule($index)
    {
        return isset($this->rule[$index]);
    }

    /**
     * Renvoie la valeur de la regle
     *
     * @return mixed Callable | string
     */
    public function getRule($index)
    {
        if (!$this->hasRule($index)) {
            throw new \Exception('Impossible de trouver la regle : ' . $index);
        }

        return $this->rule[$index];
    }


    /**
     * Renvoie la liste des Rendu
     *
     * @return array
     */
    public function getAllRule()
    {
        return $this->rule;
    }



    /**
     * Set des messages
     *
     * @param array $rule
     * @return $this
     */
    public function setMessages(array $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Ajoute un message
     *
     * @param $index
     * @param $method
     * @return $this
     */
    public function addMessage($index, $method)
    {
        $this->message[$index] = $method;
        return $this;
    }

    /**
     * Suppression d'un message
     *
     * @param $index
     * @return $this
     */
    public function removeMessage($index)
    {
        if ($this->hasMessage($index)) {
            unset($this->message[$index]);
        }

        return $this;
    }

    /**
     * Efface tous les messages
     *
     * @return $this
     */
    public function clearMessage()
    {
        $this->message = [];

        return $this;
    }

    /**
     * Renvoie true si le message existe
     *
     * @param $index
     * @return bool
     */
    public function hasMessage($index)
    {
        return isset($this->message[$index]);
    }

    /**
     * Renvoie la valeur du message
     *
     * @return mixed Callable | string
     */
    public function getMessage($index)
    {
        if (!$this->hasMessage($index)) {
            throw new \Exception('Impossible de trouver le message : ' . $index);
        }

        return $this->message[$index];
    }


    /**
     * Renvoie la liste des message
     *
     * @return array
     */
    public function getAllMessage()
    {
        return $this->message;
    }


    /**
     * Set des erruer
     *
     * @param array $error
     * @return $this
     */
    public function setError(array $error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * Ajoute une erreur
     *
     * @param $index
     * @param $message
     * @return $this
     */
    public function addError($index, $message)
    {
        $this->error[$index] = $message;
        return $this;
    }

    /**
     * Suppression d'une erruer
     *
     * @param $index
     * @return $this
     */
    public function removeError($index)
    {
        if ($this->hasError($index)) {
            unset($this->error[$index]);
        }

        return $this;
    }

    /**
     * Efface toutes les erreurs
     *
     * @return $this
     */
    public function clearError()
    {
        $this->error = [];

        return $this;
    }

    /**
     * Renvoie true si une erreur existe
     *
     * @param $index
     * @return bool
     */
    public function hasError($index)
    {
        return isset($this->error[$index]);
    }

    /**
     * Renvoie la valeur de la regle
     *
     * @return mixed Callable | string
     */
    public function getError($index)
    {
        if (!$this->hasError($index)) {
            throw new \Exception('Impossible de trouver l\'erreur : ' . $index);
        }

        return $this->error[$index];
    }


    /**
     * Renvoie la liste des erreur
     *
     * @return array
     */
    public function getAllError()
    {
        return $this->error;
    }


    /**
     * Formatage d'un message d'erreur
     *
     * @param $index
     * @param $params
     * @return string
     * @throws \Exception
     */
    public function formatError($index, $params)
    {

        // Pattern de rendu de l'erreur
        $pattern = $this->hasMessage($index) ? $this->getMessage($index) : static::MESSAGE_DEFAULT_PATTERN;

        return vsprintf($pattern, $params);
    }


    /**
     * Fonction principale de validation
     *
     * @param $value
     * @return $this
     */
    public function validate($value)
    {

        foreach($this->getAllRule() as $index => $rule) {

            // recuperation de la methodd et des paramètre
            list($method, $params) = $rule;

            // on ajoute la valeur aux paramètres
            array_unshift($params, $value);

            // si le rendu est une function anonyme
            if (is_callable($method)) {

                if (!call_user_func_array($method, $params)) {
                    $this->addError($index, $this->formatError($index, $params));
                }

                // si c'est une methode local
            } else {

                if (!method_exists($this, $method)) {
                    throw new \Exception('Impossible de trouver la method '. $method .' pour la validation : ' . $index);
                }

                if (!call_user_func_array([$this, $method], $params)){
                    $this->addError($index, $this->formatError($index, $params));
                }
            }
        }

        return $this;
    }


    /**
     * Renvoie les erreur formater en chaine de charactère
     *
     *
     * @return string
     */
    public function getErrorAsString()
    {
        $errors  = [];
        foreach($this->getAllError() as $index => $message){
            $errors[] = sprintf('%s: %s', $index, $message);
        }
        return implode(PHP_EOL, $errors);
    }



    /**
     * Renvoie si la validation est ok
     *
     * @return bool
     */
    public function isValid()
    {
        return empty($this->getAllError());
    }
}