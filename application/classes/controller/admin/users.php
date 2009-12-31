<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin controller for managing users.
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Admin_Users extends Controller_Backend {

	public function action_index()
	{
		
		// Load all users
		$users = Sprig::factory( 'user' )->load( NULL, NULL );
		
		$this->template->content = View::factory('admin/users/index')
			->set( 'users', $users );
	}

} // End Welcome