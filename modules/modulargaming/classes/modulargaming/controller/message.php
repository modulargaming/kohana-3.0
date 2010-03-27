<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @subpackage Core
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Modulargaming_Controller_Message extends Controller_Frontend {

	public $title = 'Messages';
	public $protected = true;

	public function before()
	{
		parent::before();
		
		$this->sidebar = View::factory('pm/sidebar');
		
	}
	
	public function action_index()
	{
		$this->template->content = View::factory('pm/index')
			->set( 'sidebar', $this->sidebar );
	}
	
	public function action_create()
	{
		
		$this->template->content = View::factory('pm/new')
			->set( 'sidebar', $this->sidebar );
		
	}
	
	/**
	 * Retrive usernames that start on the given param.
	 * @param string $search
	 */
	public function action_reciver( $search )
	{
		
		// Find all users whos username starts on the search string.
		$users = Jelly::select( 'user' )
			->where( 'username', 'LIKE', $search.'%' )
			->execute();
		
		// Add the usernames to an array.
		$array = array();
		foreach ( $users as $u )
		{
			$array[] = $u->username;
		}
		
		// Json encode it, and output it.
		$this->request->response = json_encode( $array );
		
	}

} // End PM
