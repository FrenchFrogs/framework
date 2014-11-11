<?php

namespace FrenchFrogs\Jquery;


class OnLoad {

    /**
     *
     * Contenu JS
     *
     * @var array
     */
    protected $script = array();

    /**
     * Ajoute du contenu a la stack
     *
     * @param $content
     * @return $this
     */
    public function add($key, $content)
    {
        $this->script[$key] = $content;
        return $this;
    }

    /**
     * Supprime le script de la stack
     *
     * @return $this
    **/
    public function remove($key)
    {
        if (isset($this->script[$key])) {
            unset($this->script[$key]);
        }
        return $this;
    }

    /**
     * @return JqueryEfface la stack js
     */
    public function clear()
    {
        $this->script = array();
        return $this;
    }

    public function getFormattedScript()
    {
        $result = implode("\n", array_values($this->script));
        $result = preg_replace('/<script(.*?)>|<\/script>/', '', $result);
        return $result;
    }

    /**
     * Renvoie le contenu du js
     *
     *
     * @return string
     */
    public function __toString() {
        return '
<script type="text/javascript">
<!--
    \$(function() {
        '.$this->getFormattedScript().'
    });

-->
</script>
';
    }
}