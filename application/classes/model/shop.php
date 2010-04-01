<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Model_Shop extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'name' => new Field_String,
			'description' => new Field_Text,
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
			->and_where( 'items.id', '=', $id)
			->limit(1);
			
		$return = $db->as_object()->execute();
		
		return $return[0];
	}
	
}