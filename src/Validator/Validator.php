<?php namespace FrenchFrogs\Validator;

/**
 *
 * Class model used to valid values
 *
 * Use polymorphisme with Trait \FrenchFrogs\Core\Validator
 *
 * Class Validator
 * @package FrenchFrogs\Validator
 */
class Validator
{

    /**
     * Rules container
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Messages container
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Error container
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Message d'erreur par default
     *
     */
    const MESSAGE_DEFAULT_PATTERN = 'Validation error : "%s"';

    /**
     * Constructor
     *
     * @param ...$params
     */
    public function __construct(...$params)
    {
        // if method "init" exist, we call it.
        if (method_exists($this, 'init')) {
            call_user_func_array([$this, 'init'], $params);
        }
    }

    /**
     * Set all the rules as an array
     *
     * @param array $rules
     * @return $this
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * Add a single rule to the rules container
     *
     * @param $index
     * @param $rule
     * @return $this
     */
    public function addRule($index, $method = null, ...$params)
    {
        $this->rules[$index] = [$method, $params];
        return $this;
    }

    /**
     * Remove a single rule from the rule container
     *
     * @param $index
     * @return $this
     */
    public function removeRule($index)
    {
        if ($this->hasRule($index)) {
            unset($this->rules[$index]);
        }

        return $this;
    }

    /**
     * Clear all the rules container
     *
     * @return $this
     */
    public function clearRules()
    {
        $this->rules = [];

        return $this;
    }

    /**
     * Return TRU if the rule $index exist in the rules container
     *
     * @param $index
     * @return bool
     */
    public function hasRule($index)
    {
        return isset($this->rules[$index]);
    }

    /**
     * Return the rule $index from the rules container
     *
     * @return mixed Callable | string
     */
    public function getRule($index)
    {
        if (!$this->hasRule($index)) {
            throw new \Exception('Rule not found: ' . $index);
        }

        return $this->rules[$index];
    }


    /**
     * Return all rules as an array
     *
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }



    /**
     * Set all messages as an array
     *
     * @param array $messages
     * @return $this
     */
    public function setMessages(array $messages)
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * Add a single message to the messsages container
     *
     * @param $index
     * @param $method
     * @return $this
     */
    public function addMessage($index, $method)
    {
        $this->messages[$index] = $method;
        return $this;
    }

    /**
     * Remove a single message from the messages container
     *
     * @param $index
     * @return $this
     */
    public function removeMessage($index)
    {
        if ($this->hasMessage($index)) {
            unset($this->messages[$index]);
        }

        return $this;
    }

    /**
     * Clear all the messages container
     *
     * @return $this
     */
    public function clearMessages()
    {
        $this->message = [];

        return $this;
    }

    /**
     * Return TRUE if the message $index exist in the messages container
     *
     * @param $index
     * @return bool
     */
    public function hasMessage($index)
    {
        return isset($this->messages[$index]);
    }

    /**
     * Return the messages $index from the messages container
     *
     * @return mixed Callable | string
     */
    public function getMessage($index)
    {
        if (!$this->hasMessage($index)) {
            throw new \Exception('Message not found : ' . $index);
        }

        return $this->messages[$index];
    }


    /**
     * Return the messages container as an array
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }


    /**
     * Set all the errors as an array
     *
     * @param array $errors
     * @return $this
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * Add a single error in the errors container
     *
     * @param $index
     * @param $message
     * @return $this
     */
    public function addError($index, $message)
    {
        $this->errors[$index] = $message;
        return $this;
    }

    /**
     * Remove the $index error from the errors container
     *
     * @param $index
     * @return $this
     */
    public function removeError($index)
    {
        if ($this->hasError($index)) {
            unset($this->errors[$index]);
        }

        return $this;
    }

    /**
     * Remove all the errors from the errors container
     *
     * @return $this
     */
    public function clearErrors()
    {
        $this->errors = [];

        return $this;
    }

    /**
     * Return TRU if the error $index exist in the errors container
     *
     * @param $index
     * @return bool
     */
    public function hasError($index)
    {
        return isset($this->errors[$index]);
    }

    /**
     * Return the error $index from the errors container
     *
     * @return mixed Callable | string
     */
    public function getError($index)
    {
        if (!$this->hasError($index)) {
            throw new \Exception('Error not found : ' . $index);
        }

        return $this->errors[$index];
    }


    /**
     * Return the errors container as an array
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }


    /**
     * Format an error
     *
     * @param $index
     * @param $params
     * @return string
     * @throws \Exception
     */
    public function formatError($index, $params)
    {

        $pattern = $this->hasMessage($index) ? $this->getMessage($index) : static::MESSAGE_DEFAULT_PATTERN;

        return vsprintf($pattern, $params);
    }


    /**
     * Valid the element
     *
     * @param $value
     * @return $this
     */
    public function valid($value)
    {

        foreach($this->getRules() as $index => $rule) {

            // extract params
            list($method, $params) = $rule;

            // If method is null, we use the index as the method name
            $method = is_null($method) ? $index : $method;

            // Build the params
            array_unshift($params, $value);

            // If it's a anonymous function
            if (is_callable($method)) {

                if (!call_user_func_array($method, $params)) {
                    $this->addError($index, $this->formatError($index, $params));
                }

            } else {// if it's a local method

                if (!method_exists($this, $method)) {
                    throw new \Exception('Method "'. $method .'" not found for validator : ' . $index);
                }

                if (!call_user_func_array([$this, $method], $params)){

                    $this->addError($index, $this->formatError($index, $params));
                }
            }
        }

        return $this;
    }


    /**
     * Return validation error formatted as a string
     *
     *
     * @return string
     */
    public function getErrorAsString()
    {
        $errors  = [];
        foreach($this->getErrors() as $index => $message){
            $errors[] = sprintf('%s: %s', $index, $message);
        }
        return implode(PHP_EOL, $errors);
    }



    /**
     * Return TRUE if validation is a success
     *
     * @return bool
     */
    public function isValid()
    {
        return empty($this->getErrors());
    }



    /**
     * ******************************
     *
     * BUILT IN VALIDATOR
     *
     * ******************************
     *
     */


    /**
     * Return FALSE if value is null or empty string
     *
     * @param $value
     * @return bool
     */
    public function required($value)
    {

        if(!$this->hasMessage('required')){
            $this->addMessage('required', 'This value is required');
        }


        if (is_null($value) || $value == '') {
            return false;
        }

        return true;
    }

    /**
     * Return TRUE if $value match URL pattern
     *
     * @param $value
     * @return bool
     */
    public function url($value)
    {
        $this->addMessage('url', 'This value is not a valid URL :%s');
        return !(filter_var($value, FILTER_VALIDATE_URL) == false);
    }


    /**
     * Return TRUE if $value match IP pattern
     *
     * @param $value
     * @return bool
     */
    public function ip($value)
    {
        $this->addMessage('ip', 'This value is not a valid IP :%s');
        return !(filter_var($value, FILTER_VALIDATE_IP) == false);
    }

    /**
     * Return TRUE if $value match Email pattern
     *
     * @param $value
     * @return bool
     */
    public function email($value)
    {
        $this->addMessage('email', 'This value is not a valid email :%s');
        return !(filter_var($value, FILTER_VALIDATE_EMAIL) == false);
    }

    /**
     *
     * Return TRUE if $value match regex pattern $pattern
     *
     * @param $value
     * @param $pattern
     * @return int
     */
    public function regex($value, $pattern)
    {
        $this->addMessage('regex',  'This value is not matching :%s');
        return preg_match($pattern, $value);
    }


    /**
     * Return true if $value exist in $array values
     *
     * @param $value
     * @param $array
     * @return bool
     */
    public function inArray($value, $array)
    {
        $this->addMessage('inArray', 'This value was not found : %s');
        return in_array($value, $array) !== false;
    }


    /**
     * Return true if the value is correct with a laravel validator string
     *
     * @param $value
     * @param $validationString
     * @return array
     */
    public function laravel($value, $validationString)
    {

        //create validator
        $validator = \Validator::make(['laravel' => $value], ['laravel' => $validationString]);


        // error message management
        if ($validator->fails() && !$this->hasMessage('laravel')) {
            $message = '';
            foreach ( $validator->errors()->get('laravel') as $m) {
                $message .= $m;
            }
            $this->addMessage('laravel', $message);
        }

        // return validation
        return $validator->valid();
    }
}