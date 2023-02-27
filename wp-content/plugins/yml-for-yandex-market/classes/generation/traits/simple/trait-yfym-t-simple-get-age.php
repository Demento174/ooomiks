<?php if (!defined('ABSPATH')) {exit;}
/**
* Traits Age for simple products
*
* @author		Maxim Glazunov
* @link			https://icopydoc.ru/
* @since		1.0.0
*
* @return 		$result_xml (string)
*
* @depends		class:		YFYM_Get_Paired_Tag
*				methods: 	get_product
*							get_feed_id
*				functions:	yfym_optionGET
*/

trait YFYM_T_Simple_Get_Age {
	public function get_age($tag_name = 'age', $result_xml = '') {
		$product = $this->get_product();
		$tag_value = '';

		$age = yfym_optionGET('yfym_age', $this->get_feed_id(), 'set_arr');
		if (empty($age) || $age === 'off' || $age === 'disabled') { } else {
			$age = (int)$age;
				$tag_value = $product->get_attribute(wc_attribute_taxonomy_name_by_id($age));
		}
		$tag_value = apply_filters('y4ym_f_simple_tag_value_age', $tag_value, array('product' => $product), $this->get_feed_id());
		if (!empty($tag_value)) {	
			$tag_name = apply_filters('y4ym_f_simple_tag_name_age', $tag_name, array('product' => $product), $this->get_feed_id());
			$result_xml = new YFYM_Get_Paired_Tag($tag_name, $tag_value);
		}

		$result_xml = apply_filters('y4ym_f_simple_tag_age', $result_xml, array('product' => $product), $this->get_feed_id());
		return $result_xml;
	}
}
?>