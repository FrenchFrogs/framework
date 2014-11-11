<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 20/10/14
 * Time: 12:59
 */

namespace FrenchFrogs\Jquery;


class OnLoad {

    /**
     *
     * Contenu JS du onload;
     *
     * @var string
     */
    protected $onload = '';


    /**
     * Ajoute du contenu a la stack onload
     *
     *
     * @param $content
     * @return $this
     */
    public function add($content)
    {
        $this->onload .= $content;
        return $this;
    }

    /**
     * @return JqueryEfface la stack js
     */
    public function clear()
    {
        $this->onload = '';
        return $this;
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
        '.$this->onload.'
    });

-->
</script>
';
    }
}