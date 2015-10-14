<?php namespace FrenchFrogs\Polliwog\Ruler\Renderer;

use FrenchFrogs\Model\Renderer\Renderer;
use FrenchFrogs\Polliwog\Ruler;

class Conquer extends Renderer
{

    /**
     *
     *
     * @var array
     */
    protected $renderers = [
        'navigation',
        'page',
    ];



    public function navigation(Ruler\Ruler\Ruler $rule)
    {

        $html = $pages = '';

        $start = false;

        foreach ($rule->getPages() as $page) {
            /**@var Ruler\Navigation\Page $page*/

            if (!$start) {
                $page->addClass('start');
            }

            if ($page->isCurrent()) {
                $page->addClass('active');
            }

            if ($page->hasPermission() && !$rule->hasPermission($page->getPermission())){
                continue;
            }

            $pages .= html('li', $page->getAttributes(), $this->render('page', $page));
        }



        $html = '
            <ul class="page-sidebar-menu">'
                . $pages .
            '</ul>';


        return $html;

    }

    public function page(Ruler\Navigation\Page $page)
    {


        $html = '';

        $current = $page->isCurrent();
        $html .= '<span class="title">'.$page->getLabel().'</span>';

        $indicator = '';
        if ($current) {
            $indicator .= ' selected';
        }

        $children = '';
        if ($page->hasChildren()) {

            $indicator .= ' arrow';

            foreach($page->getChildren() as $p) {
                /**@var Ruler\Navigation\Page $p*/

                $class = '';
                if ($p->isCurrent()) {
                    $page->addClass('active');
                    $class = 'class="active"';
                }


                $children .= '<li '.$class.'>'.html('a', ['href' => $p->getLink()], $p->getLabel()).'</li>';
            }

            $children = '<ul class="sub-menu">' . $children .'</ul>';

            $page->setLink('javascript:;');

        } else {


        }

        $html .= '<span class="'.$indicator.'"></span>';
        $html .= $children;
        $html = html('a', ['href' => $page->getLink()], $html);

        return $html;
    }




}