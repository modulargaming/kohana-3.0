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

abstract class Modulargaming_Controller_Base extends Controller implements AACL_Resource {
	
	// Settings.
	public $title = 'Undefined'; // Title of the page
	public $template = 'template/base';
	public $auto_render = TRUE; // Render the template
	public $protected = FALSE; // Require user to login.
	public $errors = array();
	
	public function before()
	{
		
		$this->session = Session::instance();
		
		// Initialize the Auth System
		$this->auth = Auth::instance();
		$this->user = $this->auth->get_user();
		
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
	
	
	
/**
	 * AACL_Resource::acl_id() implementation
	 * 
	 * @return	string 
	 */
	public function acl_id()
	{
		// Controller namespace, controller name
		return 'c:'.strtolower($this->request->controller);
	}
	
	/**
	 * AACL_Resource::acl_actions() implementation
	 * 
	 * @param	bool	$return_current [optional]
	 * @return	mixed
	 */
	public function acl_actions($return_current = FALSE)
	{
		if ($return_current)
		{
			return $this->request->action;
		}
		
		// Find all actions in this class
		$reflection = new ReflectionClass($this);
		
		$actions = array();
		
		// Add all public methods that start with 'action_'
		foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method)
		{
			if (substr($method->name, 0, 7) === 'action_')
			{
				$actions[] = substr($method->name, 7);
			}
		}
		
		return $actions;
	}
	
	/**
	 * AACL_Resource::acl_conditions() implementation
	 * 
	 * @param	Model_User	$user [optional] logged in user model
	 * @param	object    	$condition [optional] condition to test
	 * @return	mixed
	 */
	public function acl_conditions(Model_User $user = NULL, $condition = NULL)
	{
		if (is_null($user) AND is_null($condition))
		{
			// We have no conditions
			return array();
		}
		else
		{
			// We have no conditions so this test should fail!
			return FALSE;
		}
	}
	
	/**
	 * AACL_Resource::acl_instance() implementation
	 * 
	 * Note that the object instance returned should not be used for anything except querying the acl_* methods
	 * 
	 * @param	string	Class name of object required
	 * @return	Object
	 */
	public static function acl_instance($class_name)
	{
		// Return controller instance populated with manipulated request details
		$instance = new $class_name(Request::instance());
		
		$controller_name = strtolower(substr($class_name, 11));
		
		if ($controller_name !== Request::instance()->controller)
		{
			// Manually override controller name and action
			$instance->request->controller = strtolower(substr(get_class($this), 11));
			
			$instance->request->action = NULL;
		}
		
		return $instance;
	}
	
} // End Base