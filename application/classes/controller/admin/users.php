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
	
	public function before()
	{
		$this->request->action = 'index';
		parent::before();
	}
	
	
	public function action_index( $page = 1 )
	{
		// Check if the user got permission to view all users
		if ( !$this->a2->allowed( 'admin', 'users_view' ) )
			$this->request->redirect( '' );
		
		// Make sure page is numeric, if not it might be a hacking attempt
		if ( !is_numeric( $page ) )
			die( 'Not numeric' );
		
		$numb = 20; // Number of results on the page
		
		// Count the ammount of users
		$t_users = Sprig::factory( 'user' )->count();
		
		// Load all users
		$sql = new Database_Query_Builder_Select();
		$sql->offset( $page * $numb - $numb);
		$users = Sprig::factory( 'user' )->load( $sql, $numb );
		
		$this->template->content = View::factory('admin/users/index')
			->set( 't_users', $t_users )
			->set( 'users',   $users   );
	}

} // End Admin_Users