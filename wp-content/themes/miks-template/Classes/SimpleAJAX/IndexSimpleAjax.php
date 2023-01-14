<?php
namespace Classes\SimpleAJAX;


//if ( ! defined( 'WPINC' ) ) {
//	die;
//}
//
// Include the dependencies needed to instantiate the plugin.
//foreach ( glob( plugin_dir_path( __FILE__ ) . '/*.php' ) as $file ) {
//
//	include_once $file;
//}



class IndexSimpleAjax{
    public function __construct()
    {

        $methodsAJAX=get_class_methods('\Classes\SimpleAJAX\SimpleAJAX');
        unset($methodsAJAX[array_search('__construct', $methodsAJAX)]);

        new SimpleAJAX($methodsAJAX);
    }
}

function SimpleAJAX() {

	$methodsAJAX=get_class_methods('SimpleAJAX');
	unset($methodsAJAX[array_search('__construct', $methodsAJAX)]);
        
	new SimpleAJAX($methodsAJAX);

}

