<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_Shop extends Sprig {
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'name' => new Sprig_Field_Char(),
			'description' => new Sprig_Field_Text(),
		);
	}
	
	static public function get_items( $id )
	{
		
		$db = DB::select()
			->from( 'items' )
			->join( 'shop_items' )
				->on( 'items.id', '=', 'shop_items.item_id' )
			->where( 'shop_items.shop_id', '=', $id );
			
		return $db->as_object()->execute();
		
	}
	
	static public function get_one_item( $shop, $id )
	{
		
		$db = DB::select()
			->from( 'items' )
			->join( 'shop_items' )
				->on( 'items.id', '=', 'shop_items.item_id' )
			->where( 'shop_items.shop_id', '=', $shop )
			->and_where( 'items.id', '=', $id);
			
		$return = $db->as_object()->execute();
		
		return $return[0];
		
	}
	
	
}