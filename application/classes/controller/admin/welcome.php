<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Controller_Admin_Welcome extends Controller_Backend {

	public $title = 'Admin - Index';
	public $active_time = 259200; // Time since last login to be called active. (3days)

	public function action_index()
	{
		
		// Get the total number of users.
		$users = Jelly::select('user')->count();
		
		// Get the number of active users.
		$active_users = Jelly::select('user')
			->where('last_login', '>', time()-$this->active_time)
			->count();
		
		
		$this->template->content = View::factory('admin/index')
			->set( 'users', $users )
			->set( 'active_users', $active_users );
	}

} // End Welcome
