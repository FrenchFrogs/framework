<?php namespace FrenchFrogs\Ruler\Ruler;

use FrenchFrogs\Core;

class Ruler
{

    use Core\Renderer;
    use Navigation;
    use Permission;

    /**
     * Instances
     *
     * @var Ruler
     */
    static protected $instance;


    /**
     * constructor du singleton
     *
     * @return Container
     */
    static function getInstance() {

        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }


    public function renderNavigation()
    {

        if(!$this->hasRenderer()) {
            $renderer = configurator()->build('ruler.renderer.class');
            $this->setRenderer($renderer);
        }

        $render = '';
        try {
            $render = $this->getRenderer()->render('navigation', $this);
        } catch(\Exception $e){
            dd($e->getMessage());//@todo find a good way to warn the developper
        }

        return $render;
    }


    /**
     * Overload parent method for form specification
     *
     * @return string
     *
     */
    public function __toString()
    {
        return $this->render();
    }

}