<?php namespace FrenchFrogs\Table\Column;


interface Exportable
{
    public function getValue($row);
}