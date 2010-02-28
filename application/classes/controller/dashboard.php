<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Dashboard extends Controller_Frontend {
	
	public $title = 'Dashboard';
	public $protected = TRUE;
	public $load_character = true;
	
	public function action_index()
	{
		
		
		
		// Initialize the character class, and set the players character as the default.
		$char = new Character( $this->character );
		
		// Load the users history, limit with 10
		$history = Jelly::select( 'user_history' )
			->where(':primary_key', '=', $this->user->id)
			->limit( 10 )
			->execute();
		
		$this->template->content = View::factory('dashboard/index')
			->set( 'character', $this->character )
			->set( 'char', $char )
			->set( 'history', $history );
		
	}
	
}