<?php namespace FrenchFrogs\Ruler\Renderer;

use FrenchFrogs\Renderer\Renderer;
use FrenchFrogs\Ruler;

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
            /**@var Ruler\Page\Page $page*/

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

    public function page(Ruler\Page\Page $page)
    {

        // attribute initialization
        $indicator = $children = '';

        // label
        $html = '<span class="title">'.$page->getLabel().'</span>';

        if ($current = $page->isCurrent()) {
            $indicator .= ' selected';
        }

        // Render child page
        if ($page->hasChildren()) {

            // add arrow icon
            $indicator .= ' arrow';

            foreach($page->getChildren() as $p) {
                /**@var Ruler\Page\Page $p*/
                $class = '';
                if ($p->isCurrent()) {
                    $page->addClass('active');// active for parent page
                    $class = 'class="active"';
                }

                $children .= '<li '.$class.'>'.html('a', ['href' => $p->getLink()], $p->getLabel()).'</li>';
            }

            $children = '<ul class="sub-menu">' . $children .'</ul>';

            // overcharge link for javascript opening menu
            $page->setLink('javascript:;');
        }

        // render all
        $html .= '<span class="'.$indicator.'"></span>';
        $html = html('a', ['href' => $page->getLink()], $html);
        $html .= $children;

        return $html;
    }




}