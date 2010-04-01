<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Controller_Facebook extends Controller_Frontend {
	
	public $title = 'Register';
	public $require_facebook = TRUE;
	public $template = 'template/facebook';
	
	public function action_register()
	{
		
		if ( $this->user )
			Request::instance()->redirect('');
		
		
		// Experimental facebook connection
		$this->facebook = new Fb;
		
		// User accessed from facebook!
		if ( $this->facebook->validate_fb_params() )
		{
			$this->facebook->require_frame();
			$_SESSION['fb_uid'] = $this->facebook->require_login();
		}
		elseif ( !isset( $_SESSION['fb_uid'] )) // Page dosn't have the faceboko params and the sessions isnt set.
		{
			Request::instance()->redirect('');
		}
		
		// Check if the user got an account.
		$user_facebook = Jelly::select( 'user_facebook' )
			->where( 'facebook_id', '=', $_SESSION['fb_uid'] )
			->load();
		
		// If we found it, log him in.
		if ( $user_facebook->loaded() )
		{
			
			$this->a1->force_login( $user_facebook->user->username );
			$_SESSION['facebook'] = 'TRUE'; // Used for verifying if logged in using facebook.
			
			Request::instance()->redirect('');
		}
		
		
		$user = Jelly::factory('user');
		
		// Validate the form input
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule ('username', 'not_empty')
			->rule ('username', 'min_length', array(3))
			->rule ('username', 'max_length', array(20))
			->rule ('username', 'alpha_numeric')
			->rule ('email',    'email')
			->rule ('tos',      'not_empty');
		
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
			$user->role = 'facebook';
			
			try
			{
				// Create the new user
				$testy = $user->save();
				//print_r($testy);
				$user_id = mysql_insert_id();
				
				
				$ufb = Jelly::factory( 'user_facebook' );
				
				
				$ufb->facebook_id = $_SESSION['fb_uid'];
				$ufb->user = $user_id;
				$ufb->save();
				
				$this->a1->force_login( $values['username'] );
				$_SESSION['facebook'] = 'TRUE'; // Used for verifying if logged in using facebook.
				
				// Redirect the user to the login page
				$this->request->redirect( '' );
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