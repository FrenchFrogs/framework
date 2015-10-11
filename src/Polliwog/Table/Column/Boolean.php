<?php
/**
 * Created by PhpStorm.
 * User: jhouvion
 * Date: 11/10/15
 * Time: 20:55
 */

namespace FrenchFrogs\Polliwog\Table\Column;


class Boolean extends Text
{


    /**
     *
     *
     * @return string
     */
    public function render(array $row)
    {
        $render = '';
        try {
            $render = $this->getRenderer()->render('boolean', $this, $row);
        } catch(\Exception $e){
            dd($e->getMessage());
        }

        return $render;
    }

}