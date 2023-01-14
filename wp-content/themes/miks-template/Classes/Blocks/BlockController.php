<?php


namespace Classes\Blocks;


class BlockController extends \Classes\Blocks\BlockAbstractController
{

    static $VIEW_TEMPLATE = './blocks/';

    public function __construct($template,$input,$id = null,$debug=false)
    {

        parent::__construct(static::$VIEW_TEMPLATE.$template, $id, $input,$debug);
    }
}