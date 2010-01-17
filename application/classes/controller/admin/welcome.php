<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Admin_Welcome extends Controller_Backend {

	public $title = 'Admin - Index';

	public function action_index()
	{
		
		$users = Sprig::factory( 'user' )->load( NULL, NULL )->count();
		
		// Check the active users by taking todays time, and substract 1 week
		$sql = new Database_Query_Builder_Select();
		$sql->where( 'last_login', '>', time() - ( 7 * 24 * 60 * 60 ) );
		
		$active_users = Sprig::factory( 'user' )->load( $sql, NULL )->count();
		
		
		$this->template->content = View::factory('admin/index')
			->set( 'users', $users )
			->set( 'active_users', $active_users );
	}

} // End Welcome
