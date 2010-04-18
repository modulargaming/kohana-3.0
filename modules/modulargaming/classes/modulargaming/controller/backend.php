<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Controller for providing the base of backend controllers.
 *
 * @package    Modular Gaming
 * @subpackage Core
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */

abstract class Modulargaming_Controller_Backend extends Controller {
	
	public $template = 'template/admin';
	
	public $protected = TRUE; // All admin pages requires the user to be loged in.
	
	public $title = 'Undefined';
	public $auto_render = TRUE;
	public $js = array('files' => array(), 'scripts' => array());
	public $css = array();
	public $errors = array();
	
	public function add_js($js, $file = TRUE)
	{
		if ($file) {
			$this->js['files'][] = $js;
		} else {
			$this->js['scripts'][] = $js;
		}
		$this->js[] = $js;
	}
	
	public function add_css($css)
	{
		$this->css[] = $css;
	}
	
	public function before()
	{
		
		$this->internal = TRUE;
		if ($this->request === Request::instance()) {
			$this->internal = FALSE;
		}
		
		$this->add_css('assets/css/admin.css');
		
		$this->add_js('assets/js/jquery.js'); // jQuery
		$this->add_js('assets/js/jquery-ui.js'); // jQuery UI
		$this->add_js('assets/js/admin/jquery.scrollTo.js'); // jQuery scrollTo
		$this->add_js('assets/js/admin/jquery.localscroll.js'); // jQuery localscroll
		//$this->add_js('assets/js/jquery.validate.js'); // Form Validation
		$this->add_js('assets/js/admin/main.js');
		
		
		$this->a2 = A2::instance();
		$this->a1 = $this->a2->a1;
		$this->user = $this->a2->get_user();
		
		
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
		View::bind_global('errors', $this->errors);
		
		if ($this->auto_render === TRUE && !Request::$is_ajax )
		{
			
			// Load the template
			$this->template = View::factory($this->template)
				->bind('js',  $this->js)
				->bind('css', $this->css);
			
			$this->template->errors = array();
		}
		
		// Check if the page is protected and if the user is not logged in
		if ($this->protected && !$this->user) {
			// Redirect the user to login page
			Request::instance()->redirect('account/login');
		}
		
	}
	
	public function after()
	{
		
		View::set_global('title', __($this->title));
		
		if ($this->auto_render === TRUE AND ! Request::$is_ajax AND ! $this->internal)
		{
			// Assign the template as the request response and render it
			$this->request->response = $this->template;
		}
	}	
} // End Backend
