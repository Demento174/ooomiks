<?php

namespace Classes\Import;

use Classes\Import\Suppliers\Matrix;

class Init
{
    public function __construct()
    {
        $this->add_menu();
    }


    private function add_menu()
    {
        $menu = new \Classes\Menu\Menu('Импорт товаров','Импорт товаров','administrator',[$this,'handler'],'',2);
        new \Classes\Menu\SubMenu($menu,'Matrix','Matrix','administrator',[$this,'handler']);
    }

    public function handler()
    {
        \Classes\Import\Suppliers\Matrix::init();
    }
}