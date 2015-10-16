<?php namespace FrenchFrogs\Polliwog\Table\Column;

use FrenchFrogs\Core;

class Button extends Link
{
	use Core\Button;

    /**
     *
     *
     * @return string
     */
    public function render(array $row)
    {
        $render = '';
        try {
            // on force l'affichage du label si pas d'icon
            if (!$this->hasIcon()) {
                $this->disableIconOnly();
            }
//            $this->addClass($this->getOption())->addClass($this->getSize());
            $render = $this->getRenderer()->render('button', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }
}