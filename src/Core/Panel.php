<?php namespace FrenchFrogs\Core;

use FrenchFrogs\Polliwog;

trait Panel
{


    /**
     * Polliwog Panel
     *
     * @var Polliwog\Panel\Panel\Panel
     */
    protected $panel;


    /**
     * Setter for $panel Attribute
     *
     * @param \FrenchFrogs\Polliwog\Panel\Panel\Panel $panel
     * @return $this
     */
    public function setPanel(Polliwog\Panel\Panel\Panel $panel)
    {
        $this->panel = $panel;
        return $this;
    }

    /**
     * Set default panel
     *
     * @param string $title
     * @return \FrenchFrogs\Core\Panel
     */
    public function useDefaultPanel($title = '')
    {

        /** @var $panel \FrenchFrogs\Polliwog\Panel\Panel\Panel */
        $panel = configurator()->get('panel.class');
        $panel = new $panel;
        $panel->setTitle(strval($title));

        return $this->setPanel($panel);
    }

    /**
     * Getter for $panel attribute
     *
     * @return \FrenchFrogs\Polliwog\Panel\Panel\Panel
     */
    public function getPanel()
    {
        return $this->panel;
    }


    /**
     * Return TRUE if a Panel is set
     *
     * @return bool
     */
    public function hasPanel()
    {
        return isset($this->panel);
    }

}