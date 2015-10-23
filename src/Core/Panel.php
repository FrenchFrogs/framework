<?php namespace FrenchFrogs\Core;

use FrenchFrogs;

trait Panel
{


    /**
     * Polliwog Panel
     *
     * @var FrenchFrogs\Panel\Panel\Panel
     */
    protected $panel;


    /**
     * Setter for $panel Attribute
     *
     * @param \FrenchFrogs\Panel\Panel\Panel $panel
     * @return $this
     */
    public function setPanel(FrenchFrogs\Panel\Panel\Panel $panel)
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

        /** @var $panel \FrenchFrogs\Panel\Panel\Panel */
        $panel = configurator()->get('panel.class');
        $panel = new $panel;
        $panel->setTitle(strval($title));

        return $this->setPanel($panel);
    }

    /**
     * Getter for $panel attribute
     *
     * @return \FrenchFrogs\Panel\Panel\Panel
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