<?php namespace FrenchFrogs\Container;

/**
 * Javascript container
 *
 * Class Javascript
 * @package FrenchFrogs\Container
 */
class Javascript extends Container
{

    const NAMESPACE_DEFAULT = 'onload';


    /**
     * Build a jquery call javascript code
     *
     * @param $selector
     * @param $function
     * @param ...$params
     * @return string
     */
    public function build($selector, $function, ...$params)
    {
        $attributes = [];

        foreach($params as $p) {
            if (is_array($p)) {
                $attributes[] = json_encode($p, JSON_PRETTY_PRINT );
            } elseif (substr($p,0,7) == 'function') {
                $attributes[] = str_replace('"', '\"', $p);
            } else {
                $attributes[] = '"'.str_replace('"', '\"', $p).'"';
            }
        }

        return sprintf('$("%s").%s(%s);', $selector, $function, implode(',', $attributes));
    }

    /**
     * Append build javascript to $container attribute
     *
     * @param $selector
     * @param $function
     * @param ...$params
     * @return $this
     */
    public function appendJs($selector, $function, ...$params)
    {
        array_unshift($params, $selector, $function);
        $this->append(call_user_func_array([$this, 'build'], $params));
        return $this;
    }

    /**
     * Prepend build javascript to $container attribute
     *
     * @param $selector
     * @param $function
     * @param ...$params
     * @return $this
     */
    public function prependJs($selector, $function, ...$params)
    {
        array_unshift($params, $selector, $function);
        $this->append(call_user_func_array([$this, 'build'], $params));
        return $this;
    }

    /**
     * Add alert() javascript function to the container
     *
     * @param $message
     * @return $this
     */
    public function alert($message)
    {
        $this->append(sprintf('alert("%s")', $message));
        return $this;
    }

    /**
     * Add console.log() javascript function to the container
     *
     * @param $message
     * @return $this
     */
    public function log($message)
    {
        $this->append(sprintf('console.log("%s")', $message));
        return $this;
    }


    /**
     * Add toastr warning message
     *
     * @param $body
     * @param string $title
     * @return $this
     */
    public function warning($body = '', $title = '')
    {
        $body = empty($body) ?  configurator()->get('toastr.warning.default') : $body;
        $this->append(sprintf('toastr.warning("%s", "%s")', $body, $title));
        return $this;
    }

    /**
     * Add toastr success message
     *
     * @param $body
     * @param string $title
     * @return $this
     */
    public function success($body = '', $title = '')
    {
        $body = empty($body) ?  configurator()->get('toastr.success.default') : $body;
        $this->append(sprintf('toastr.success("%s", "%s")', $body, $title));
        return $this;
    }


    /**
     * Add toastr success message
     *
     * @param $body
     * @param string $title
     * @return $this
     */
    public function error($body = '', $title = '')
    {
        $body = empty($body) ?  configurator()->get('toastr.error.default') : $body;
        $this->append(sprintf('toastr.error("%s", "%s")', $body, $title));
        return $this;
    }

    /**
     * Close the remote modal
     *
     * @return $this
     */
    public function closeRemoteModal()
    {
        $this->appendJs('#modal-remote', 'modal', 'hide');
        return $this;
    }

    /**
     * ReloadAjaxDatatable
     *
     * @param bool|false $resetPaging
     * @return $this
     */
    public function reloadDataTable($resetPaging = false)
    {
        $this->append('jQuery(".dataTable").DataTable().ajax.reload(null, '. ($resetPaging ?  'true' : 'false') .')');
        return $this;
    }
}