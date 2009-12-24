<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_User extends Sprig implements Acl_Role_Interface {
	 
	protected $_title_key = 'username';

	protected $_sorting = array('username' => 'asc');

	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'username' => new Sprig_Field_Char(array(
				'empty'  => FALSE,
				'unique' => TRUE,
				'min_length' => 3,
				'max_length' => 20,
			)),
			'email' => new Sprig_Field_Email(array(
				'empty' => FALSE,
			)),
			'password' => new Sprig_Field_Char(array(
				'empty' => FALSE,
			)),
			'token' => new Sprig_Field_Char(array(
				'empty' => TRUE,
			)),
			'last_login' => new Sprig_Field_Timestamp(array(
				'empty' => TRUE,
			)),
			// Dont remove the rule, its a junk value i needed to avoide an error.
			'logins' => new Sprig_Field_Float(array(
				 'empty' => TRUE,
				 'rules' => array(
				 	'numeric' => array(),
				 )
			)),
			'role' => new Sprig_Field_Char(array(
				 'empty' => TRUE,
			)),
			
			
			'character' => new Sprig_Field_HasOne(array(
                'model' => 'Character',
			)),
			
		);
	}
	
	function get_role_id()
	{
		return $this->role;
	}
	
}