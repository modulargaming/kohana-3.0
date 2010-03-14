<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Model for managing the user table
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_User extends Modulargaming_Model_User {

	
	static public function get_items( $id )
	{
		
		$db = DB::select()
			->from( 'items' )
			->join( 'user_items' )
				->on( 'items.id', '=', 'user_items.item_id' )
			->where( 'user_items.user_id', '=', $id );
			
		return $db->as_object()->execute();
		
	}
	
	static public function get_item( $user_id, $id )
	{
		$db = DB::select()
			->from( 'items' )
			->join( 'user_items' )
				->on( 'items.id', '=', 'user_items.item_id' )
			->where( 'user_items.user_id', '=', $user_id )
			->and_where( 'items.id', '=', $id );
		
		$return = $db->as_object()->execute();
		return $return[0];
	}
	
}