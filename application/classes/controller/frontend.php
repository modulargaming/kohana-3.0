<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

abstract class Controller_Frontend extends Modulargaming_Controller_Frontend {
	
	public $load_character = FALSE;
	public $require_character = FALSE;
	
	public $require_facebook = FALSE;
	public $is_facebook = FALSE;
	
	public function before()
	{
		
		parent::before();
		
		// Make sure the user got a character if characters is required in the controller
		if ( $this->load_character ) {
			
			$this->character = Jelly::select( 'character' )
				->where( 'user', '=', $this->user->id )
				->load();
			
		}
		
		if ( $this->load_character && $this->require_character )
		{
			
			if ( !$this->character->loaded() )
				Request::instance()->redirect('character/create');
			
		}
		
		/*
		
		// Experimental facebook connection
		$this->facebook = new Fb;
		
		// User accessed from facebook!
		if ( $this->facebook->validate_fb_params() )
		{
		
			$this->facebook->require_frame();
			
			// Gets the ID of the user.
			$_SESSION['fb_uid'] = $this->facebook->require_login();
			
		}
		
		if ( isset( $_SESSION['fb_uid'] ) )
		{
			echo 'Logged in: ' . $_SESSION['fb_uid'];
			$this->is_facebook = true;
			
		}
		
		if ( $this->require_facebook && !$this->is_facebook )
		{
			Request::instance()->redirect('');
		}
		
		*/
		
	}
	
} // End Frontend
