<?php namespace FrenchFrogs\Table\Column;


/**
 * Trait for column with remote process
 *
 * Class RemoteProcess
 * @package FrenchFrogs\Table\Column
 */
trait RemoteProcess
{


    /**
     * frunction to process the column
     *
     * @var Callable
     */
    protected $remoteProcess;


    /**
     * Return TRUE if remote process is set
     *
     * @return bool
     */
    public function hasRemoteProcess()
    {
        return isset($this->remoteProcess) && is_callable($this->remoteProcess);
    }


    /**
     * Set $remoteProcess
     *
     * @param $function
     * @return $this
     */
    public function setRemoteProcess($function)
    {
        if (!is_callable($function)) {
            throw new \LogicException('"'.$function.'" is not callable');
        }

        $this->remoteProcess = $function;
        return $this;
    }


    /**
     * Getter for $remoteProcess
     *
     * @return Callable
     */
    function getRemoteProcess()
    {
        return $this->remoteProcess;
    }

    /**
     * Execute $remoteProcess with params
     *
     * @param array ...$params
     * @return mixed
     */
    function remoteProcess(...$params)
    {
        return call_user_func_array($this->remoteProcess, $params);
    }



}