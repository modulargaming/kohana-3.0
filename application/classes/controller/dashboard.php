<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Controller_Dashboard extends Controller_Frontend {
	
	public $title = 'Dashboard';
	public $protected = TRUE;
	
	public function action_index()
	{
		
		/*
		// Initialize the character class, and set the players character as the default.
		$char = new Character( $this->character );
		*/
		
		// Load the users history, limit with 10
		$history = Jelly::select( 'user_history' )
			->where(':primary_key', '=', $this->user->id)
			->limit( 10 )
			->execute();
		
		$this->left = '';
		Event::run('dashboard-left', $this);
		
		$this->template->content = View::factory('dashboard/index')
			->set('left', $this->left)
			->set('history', $history);
		
	}
	
}
