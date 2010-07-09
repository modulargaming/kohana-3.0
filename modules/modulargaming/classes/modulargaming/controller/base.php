<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @category   Controllers
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */

abstract class Modulargaming_Controller_Base extends Controller {
	
	// Settings.
	public $title = 'Undefined'; // Title of the page
	public $template = 'template/base';
	public $auto_render = TRUE; // Render the template
	public $protected = FALSE; // Require user to login.
	public $errors = array();
	
	public function before()
	{
		
		// Initialize the Auth System
		// $this->a2 = A2::instance();
		// $this->a1 = $this->a2->a1;
		// $this->user = $this->a2->get_user();
		
		$this->user = false;
		
		// Setup the user specific settings
		if ($this->user)
		{
			if ($this->user->language)
			{
				I18n::lang($this->user->language);
			}
			
			//Time::$offset = '';
			//Time::$display = '';
		}
		//I18n::lang('en');
		
		View::set_global('user', $this->user);		
		
		$this->MG = new ModularGaming($this->user);
		
		if ($this->auto_render === TRUE && !Request::$is_ajax)
		{

			// Load the template
			$this->template = View::factory($this->template);

		}
		
		// Check if the page is protected and if the user is not logged in
		if ($this->protected && !$this->user) {
			// Redirect the user to login page
			Request::instance()->redirect('account/login');
		}
		
		// Run the before events.
		// Event::run('before', $this);
		
	}
	
	public function after()
	{
		
		View::set_global('title', __($this->title));
		
		if ($this->auto_render === TRUE && !Request::$is_ajax)
		{
			// Assign the template as the request response and render it
			$this->request->response = $this->template;
		}
	}	
} // End Base