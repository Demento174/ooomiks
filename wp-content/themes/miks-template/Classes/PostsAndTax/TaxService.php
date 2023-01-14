<?php
namespace Classes\PostsAndTax;

class TaxService extends TaxonomyAbstract {

    static string $taxType ='tax_service';
    static string $postClass='\Classes\PostsAndTax\PostService';

    public function __construct($id)
    {
        parent::__construct($id);
    }

    public function get_id():int
    {
        return (int) $this->id;
    }

    public function get_title():string
    {
        return $this->title;
    }

    public function get_link():string
    {
        return $this->link;
    }




}