<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Facebook extends Controller_Frontend {
	
	public $title = 'Register';
	public $require_facebook = TRUE;
	
	public function action_register()
	{
		
		if ( $this->user )
			Request::instance()->redirect('');
		
		$user_facebook = Jelly::select( 'user_facebook' )
			->where( 'facebook_id', '=', $_SESSION['fb_uid'] )
			->load();
			
		if ( $user_facebook->loaded() )
			die( 'user_found' );
		
		$user = Jelly::factory('user');
		
		// Validate the form input
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule ('username',         'not_empty')
			->rule ('username',         'alpha_numeric')
			->rule ('email',            'email')
			->rule ('tos',              'not_empty');
		
		if ($post->check())
		{
			
			$values = array(
				'username' => $post['username'],
				'email'    => $post['email'],
			);
			
			// Assign the validated data to the sprig object
			$user->set( $values );
			
			// Hash the password
			$user->password = '';
			
			// Set the default role for registered user.
			$user->role = 'user';
			
			try
			{
				// Create the new user
				$user->save();
				
				// Redirect the user to the login page
				$this->request->redirect( 'facebook/login' );
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
		
		if ( !empty($this->errors) )
			Message::set( Message::ERROR, $this->errors );
		
		$this->template->content = View::factory('facebook/register')
			->set( 'post',   $post->as_array() );
		
		
	}
	
}