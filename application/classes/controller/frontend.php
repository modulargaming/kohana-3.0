<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

abstract class Controller_Frontend extends Modulargaming_Controller_Frontend {
	
	/*
	public $load_character = FALSE;
	public $require_character = FALSE;
	
	public $require_facebook = FALSE;
	public $is_facebook = FALSE;
	
	public function before()
	{
		if ( isset( $_SESSION['facebook'] ) )
		{
			$this->template = 'template/facebook';
		}
		parent::before();
		
		$this->add_js( 'assets/js/jquery.tooltip.js' );
		
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
		
		if ( isset( $_SESSION['facebook'] ) )
		{
			
			$this->css = array();
			$this->add_css('assets/css/facebook.css');
			
			$this->facebook = new Fb;
			$this->facebook->api_client->set_user = $_SESSION['fb_uid'];
			
			//$facebook->api_client->users_getInfo($uid, 'last_name, first_name'); 			
			
		}
		
	}
	*/
} // End Frontend
