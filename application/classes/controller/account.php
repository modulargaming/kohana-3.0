<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Account extends Controller_Frontend {
	
	public function action_index()
	{
		if ( !$this->user )
			$this->request->redirect( 'account/login' );
		
		$this->template->content = View::factory('account/index');
	}
	
	public function action_login()
	{
		// If the user is alredy logged in, send him to his UCP (User controll panel)
		if ( $this->user )
			$this->request->redirect( 'account' );
		
		// Validate the form input
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule('username', 'not_empty')
			->rule('username', 'min_length', array(3))
			->rule('username', 'max_length', array(20))
			->rule('password', 'not_empty');
		
		// Check if the validate success, and try to log him in.
		if($post->check())
		{
			if ($this->a1->login($post['username'],$post['password'], isset($_POST['remember']) ? (bool) $_POST['remember'] : FALSE))
			{
				$this->request->redirect( '' );
			}
		}
		
		$this->template->content = View::factory('account/login');
		
	}
	
	public function action_register()
	{
		if ( $this->user )
			$this->request->redirect( 'account' );
		
		$sprig = Sprig::factory('user');
		
		// Check if we got a post request
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rules('username',         $sprig->field('username')->rules)
			->rules('email',            $sprig->field('email')->rules)
			->rule ('email_confirm',    'matches', array('email'))
			->rule ('password',         'min_length', array ( 6 ) )
			->rule ('password',         'max_length', array( 20 ) )
			->rule ('password_confirm', 'matches', array('password'))
			->rule ('tos',              'not_empty');
		
		if ($post->check())
		{
			
			// Assign the validated data to the sprig object
			$sprig->values( $post->as_array());
			
			// Hash the password
			$sprig->password = $this->a1->hash_password( $post['password'] );
			
			try
			{
				// Create the new user
				$sprig->create();
				
				// Redirect the user to the login page
				$this->request->redirect( 'account/login' );
			}
			catch (Validate_Exception $e)
			{
				// Get the errors using the Validate::errors() method
				$this->errors = $e->array->errors('register');
			}
			
		}
		else
		{
			$this->errors = $post->errors('register');
		}
		
		$this->template->content = View::factory('account/register')
			->set('errors', $this->errors)
			->set('post', $post->as_array());
	}
	
	public function action_logout()
	{
		if ($this->user)
			$this->a1->logout();
		
		$this->request->redirect( '' );
	}
	
	public function action_confirm($key)
	{
		
	}

} // End Account