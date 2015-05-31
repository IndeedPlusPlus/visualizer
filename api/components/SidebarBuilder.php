<?php


namespace app\components;


class SidebarBuilder
{
    protected $sidebar = [];

    public function pushItem($text = null, $sref = null, $icon = null, $translate = null, $heading = false)
    {
        $item = [];
        if ($text)
            $item['text'] = $text;
        if ($sref)
            $item['sref'] = $sref;
        if ($icon)
            $item['icon'] = $icon;
        if ($translate)
            $item['translate'] = $translate;
        if ($heading)
            $item['heading'] = true;
        $this->sidebar[] = $item;
    }

    public function pushMenu($text = null, $sref = null, $icon = null, $translate = null, $submenu = [])
    {
        $item = [];
        if ($text)
            $item['text'] = $text;
        if ($sref)
            $item['sref'] = $sref;
        if ($icon)
            $item['icon'] = $icon;
        if ($translate)
            $item['translate'] = $translate;
        $item['submenu'] = $submenu;
        $this->sidebar[] = $item;
    }

    public function pushHeader()
    {
        $this->pushItem('Menu', null, null, 'sidebar.heading.HEADER', true);
        $this->pushItem('Welcome', 'app.singleview', 'fa fa-file-o', 'sidebar.nav.SINGLEVIEW');
        $this->pushItem('Administration', 'app.administration', 'fa fa-gears', 'sidebar.nav.ADMINISTRATION');
    }


    public function toArray()
    {
        return $this->sidebar;
    }
}