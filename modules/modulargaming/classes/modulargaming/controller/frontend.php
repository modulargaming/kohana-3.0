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

abstract class Modulargaming_Controller_Frontend extends Controller_Base {
	
	// Settings.
	public $template = 'template/main';
	
	public function before()
	{
		
		parent::before();
		
		Asset::add('assets/css/main.css', 'css');
		Asset::add('assets/css/redmond/jquery-ui.css', 'css');
		
		Asset::add('assets/js/jquery.js', 'js');
		Asset::add('assets/js/jquery.validate.js', 'js');
		Asset::add('assets/js/jquery-ui.js', 'js');
		Asset::add('assets/js/main.js', 'js');		
		
		if ($this->auto_render === TRUE && !Request::$is_ajax)
		{
			
			$this->sidebar_left = array();
			Event::run('sidebar_left', $this);
			
			$this->sidebar_right = array();
			Event::run('sidebar_right', $this);

			// Load the template
			$this->template->sidebar_left = $this->sidebar_left;
			$this->template->sidebar_right = $this->sidebar_right;
		

}
		
		// Run the before events.
		Event::run('before', $this);
		
		
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
} // End Frontend
