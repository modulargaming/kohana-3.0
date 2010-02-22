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
	
	
	public $protected = TRUE;
	public $title = 'Dashboard';
	
	public function action_index()
	{
		$character = $this->user->character;
		$character->load();
		
		// Initialize the character class, and set the players character as the default.
		$char = new Character( $character );
		
		//$this->MG->add_history( 'hi' );
		
		$history = Sprig::factory( 'user_history', array( 'user' => $this->user->id ) )->load( NULL, 10 );
		
		$this->template->content = View::factory('dashboard/index')
			->set( 'character', $character )
			->set( 'char', $char )
			->set( 'history', $history );
		
	}
	
}