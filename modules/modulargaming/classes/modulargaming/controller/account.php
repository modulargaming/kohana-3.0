<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Controller for managing the basic user actions (register, login, logout)
 *
 * @package    Modular Gaming
 * @subpackage Core
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Modulargaming_Controller_Account extends Controller_Frontend {
	
	public $title = 'Account';

	/**
	 * Settings page, for logged in users.
	 */
	public function action_index()
	{
		// Make sure the user is logged in.
		if ( !$this->user )
			$this->request->redirect( 'account/login' );
		
		
		$this->title = 'Settings';
		$this->template->content = View::factory('account/index');
		
	}
	
	/**
	 * Login page, verifies submited data.
	 */
	public function action_login()
	{
		// If the user is already logged in, send them to their settings.
		if ( $this->user )
			$this->request->redirect( 'account' );
		
		$this->title = 'Login';
		
		// Validate the form input
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule('username', 'not_empty')
			->rule('username', 'min_length', array(3))
			->rule('username', 'max_length', array(20))
			->rule('password', 'not_empty');
		
		// Check if the validation passed and try to log them in.
		if ( $post->check() )
		{
			if ($this->a1->login($post['username'],$post['password'], isset($_POST['remember']) ? (bool) $_POST['remember'] : FALSE))
			{
			
				// If it is an ajax request, output 1 to verify the user has been logged in.
				if ( Request::$is_ajax )
				{
					die('1');
				}
				
				$this->request->redirect( '' );
			}
			else
			{
				$this->errors[] = 'Incorrect username or password';
			}
		}
		else
		{
			$this->errors = $post->errors('register');
		}
		
		
		if ( Request::$is_ajax && !empty( $this->errors ) )
		{
			die( json_encode( $this->errors ) );
		}
		
		
		if ( !empty($this->errors) )
			Message::set( Message::ERROR, $this->errors );
		
		$this->template->content = View::factory('account/login');
		
	}
	
	/**
	 * Register page, verifies submited data.
	 */
	public function action_register()
	{
		// If the user is already logged in, send them to their settings.
		if ( $this->user )
			$this->request->redirect( 'account' );
		
		$this->title = 'Register';
		$this->add_js('assets/js/register.js');
		
		$user = Jelly::factory('user');
		
		// Validate the form input
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule('username', 'not_empty')
			->rule('username', 'alpha_numeric')
			->rule('email', 'not_empty')
			->rule('email', 'email')
			->rule('email_confirm', 'matches', array('email'))
			->rule('password', 'min_length', array ( 6 ) )
			->rule('password', 'max_length', array( 20 ) )
			->rule('password_confirm', 'matches', array('password'))
			->rule ('tos', 'not_empty')
			->callback('captcha', array($this, 'captcha_valid'));
		
		if ($post->check())
		{
			
			$values = array(
				'username' => $post['username'],
				'password' => $this->a1->hash_password($post['password']),
				'email' => $post['email'],
				'role' => 'user',
			);
			
			// Assign the validated data to the sprig object
			$user->set($values);
			
			try
			{
				// Create the new user
				$user->save();
				
				// Redirect the user to the login page
				$this->request->redirect('account/login');
			}
			catch (Validate_Exception $e)
			{
				// Get the errors using the Validate::errors() method
				$this->errors = $e->array->errors('register');
			}
			
		}
		else
		{
			$this->errors = $post->errors('account/register');
		}
		
		if ( ! empty($this->errors))
			Message::set(Message::ERROR, $this->errors);
		
		$this->template->content = View::factory('account/register')
			->set('post', $post->as_array());
	}
	
	/**
	 * Logout
	 */
	public function action_logout()
	{
		if ($this->user)
			$this->a1->logout();
		
		$this->request->redirect( '' );
	}
	
	/**
	 * Validate the captcha
	 * @param Validate $array
	 * @param string   $field
	 */
	public function captcha_valid(Validate $array, $field)
	{
		if ( ! Captcha::valid($array[$field])) $array->error($field, 'invalid');
	}
	
	/**
	 * Placeholder for email verification
	 * @param string $key
	 */
	public function action_confirm($key)
	{
		
	}
	
	/**
	 * Display the Term Of Service
	 */
	public function action_tos()
	{
		// If it's an ajax request, send only the view.
		if ( ! Request::$is_ajax) {
			$this->template->content = View::factory('account/tos');
		}
		else
		{
			$this->request->response = View::factory('account/tos');
		}
	}

} // End Account
