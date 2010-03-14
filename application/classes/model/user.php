<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Model for managing the user table
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_User extends Jelly_Model implements Acl_Role_Interface {
	 
	protected $_title_key = 'username';

	protected $_sorting = array('id' => 'asc');

	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields += array(
			'id' => new Field_Primary,
			
			'username' => new Field_String(array(
				'empty'  => FALSE,
				'unique' => TRUE,
				'min_length' => 3,
				'max_length' => 20,
			)),
			
			'email' => new Field_Email,
			
			'password' => new Field_String,
			
			'token' => new Field_String(array(
				'empty' => TRUE,
			)),
			
			'last_login' => new Field_Timestamp(array(
				'empty'  => TRUE,
				'pretty_format' => 'Y-m-d H:i',
			)),
			
			// Do not remove this rule, it is a junk value I needed to avoid an error.
			'logins' => new Field_Float(array(
				 'default' => 0,
				 'rules' => array(
				 	'numeric' => array(),
				 )
			)),
			
			'role' => new Field_String(array(
				 'empty' => TRUE,
			)),
			
		);
	}
	
	function get_role_id()
	{
		return $this->role;
	}
	
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