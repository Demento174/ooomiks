<?php


namespace Classes\Blocks\Blocks;

use Classes\PostsAndTax\TaxCat;
use Classes\WC\WCController;

class SearchField
{
    static $template = 'search_form';

    private $second_level_category= false;
    private $manufacturers= false;


    public function __construct()
    {
        $this->set_second_level_category();
        $this->set_manufacturers();
    }

    private function set_second_level_category()
    {
        $this->second_level_category = TaxCat::get_termSecondLevel();
    }

    private function  set_manufacturers()
    {
        $this->manufacturers = WCController::get_all_values_attribute('manufacturer');
    }


    public function render()
    {
        renderBlock(self::$template,
            [
                'second_level_category'=>$this->second_level_category,
                'manufacturers'=>$this->manufacturers
            ]);
    }
}