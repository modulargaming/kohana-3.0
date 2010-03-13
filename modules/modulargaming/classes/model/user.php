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
			
			'email' => new Field_Email(array(
				'empty' => FALSE,
			)),
			
			'password' => new Field_String(array(
				'empty' => FALSE,
			)),
			
			'token' => new Field_String(array(
				'empty' => TRUE,
			)),
			
			'last_login' => new Field_Timestamp(array(
				'empty'  => TRUE,
				'pretty_format' => 'Y-m-d H:i',
			)),
			
			// Do not remove this rule, it is a junk value I needed to avoid an error.
			'logins' => new Field_Float(array(
				 'empty' => TRUE,
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
	
}