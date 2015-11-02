<?php namespace FrenchFrogs\Core;

/**
 * Trait for validator polymorphisme
 *
 * Class Validator
 * @package FrenchFrogs\Core
 */
trait Validator
{

    /**
     * Validator container
     *
     * @var \FrenchFrogs\Validator\Validator
     */
    protected $validator;


    /**
     * Getter
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
     * Return TRUE if validator is set
     *
     * @return bool
     */
    public function hasValidator()
    {
        return isset($this->validator);
    }


    /**
     * Add a single validator with message to the validator container
     *
     * @param $index
     * @param null $method
     * @param array $params
     * @param null $message
     * @return $this
     */
    public function addValidator($index, $method = null, array $params = [], $message = null)
    {
        // set up params
        array_unshift($params, $method);
        array_unshift($params, $index);

        call_user_func_array([$this->getValidator(), 'addRule'], $params);

        // Message management
        if (!is_null($message)) {
            $this->getValidator()->addMessage($index, $message);
        }

        return $this;
    }


    /**
     * Shortcut to the main function of the model
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
     * Return TRUE if the element is valid
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->getValidator()->isValid();
    }


    /**
     * Return the error message format as a string
     *
     * @return string
     */
    public function getErrorAsString()
    {
        return $this->getValidator()->getErrorAsString();
    }
}