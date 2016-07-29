<?php namespace FrenchFrogs\Ruler\Renderer;

use FrenchFrogs\Renderer\Renderer;
use FrenchFrogs\Ruler;

class AdminLTE extends Renderer
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


    /**
     * @param \FrenchFrogs\Ruler\Ruler\Ruler $rule
     * @return string
     * @throws \Exception
     */
    public function navigation(Ruler\Ruler\Ruler $rule)
    {
        foreach ($rule->getPages() as $page) {
            if ($page->hasPermission() && !$rule->hasPermission($page->getPermission())){
                continue;
            }
            $content = $this->render('page', $page);
        }

        $content = '<ul class="sidebar-menu">
                        <li class="header">NAVIGATION</li>
                        '. $content .'
                    </ul>';

        return $content;
    }

    /**
     *
     *
     * @param \FrenchFrogs\Ruler\Page\Page $page
     * @return string
     */
    public function page(Ruler\Page\Page $page)
    {
        // label
        $html = '<span>'.$page->getLabel().'</span>';

        // attribute initialization
        $children = '';

        // Render child page
        if ($page->hasChildren()) {

            $html .= '<i class="fa fa-angle-left pull-right"></i>';

            foreach($page->getChildren() as $p) {
                /**@var Ruler\Page\Page $p*/
                $class = '';
                if ($p->isCurrent()) {
                    $page->addClass('active');// active for parent page
                    $class = 'class="active"';
                }

                if ($p->hasPermission() && !\ruler()->hasPermission($p->getPermission())){
                    continue;
                }

                $children .= '<li '.$class.'>'.html('a', ['href' => $p->getLink()], '<i class="fa fa-circle-o"></i> ' . $p->getLabel()).'</li>';
            }

            $children = '<ul class="treeview-menu">' . $children .'</ul>';

            // overcharge link for javascript opening menu
            $page->setLink('javascript:;');
        }

        $page->addClass('treeview');

        // render all
        $html = html('a', ['href' => $page->getLink()], $html);
        $html = html('li', ['class' => $page->getClasses()], $html . $children);

        return $html;
    }




}