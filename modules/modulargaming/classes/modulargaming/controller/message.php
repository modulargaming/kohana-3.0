<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @subpackage Core
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Modulargaming_Controller_Message extends Controller_Frontend {

	public $title = 'Messages';
	public $protected = true;

	public function before()
	{
		parent::before();
		
		$this->sidebar = View::factory('message/sidebar');
		
	}
	
	/**
	 * Display the inbox.
	 */
	public function action_index()
	{
		$this->template->content = View::factory('message/index')
			->set( 'sidebar', $this->sidebar );
	}
	
	/**
	 * Create a new post.
	 */
	public function action_create()
	{
		
		// Validate the form input
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule('to', 'not_empty')
			->rule('to', 'min_length', array(3))
			->callback('to', array($this, 'username_exists'))
			->rule('title', 'not_empty')
			->rule('title', 'min_length', array(3))
			->rule('message', 'not_empty')
			->rule('message', 'min_length', array(10));
		
		if ($post->check())
		{
			
			$values = array(
				'to'       => $post['to_id'],
				'from'     => $this->user->id,
				'status'   => 'sent',
				'title'    => $post['title'],
				'message'  => $post['message'],
			);
			
			$message = Jelly::factory('message');
			
			// Assign the validated data to the sprig object
			$message->set($values);
			$message->save();
			
			Message::set(Message::SUCCESS, 'You sent away the message to '.$post['to']);
			
			$this->request->redirect('message');
			
		}
		else
		{
			$this->errors = $post->errors('message');
		}
		
		if ( ! empty($this->errors))
			Message::set(Message::ERROR, $this->errors);
		
		$this->template->content = View::factory('message/create')
			->set('sidebar', $this->sidebar)
			->set('post', $post->as_array());
		
	}
	
	/**
	 * Retrive usernames that start on the given param.
	 * @param string $search
	 */
	public function action_reciver( $search )
	{
		
		// Find all users whos username starts on the search string.
		$users = Jelly::select('user')
			->where('username', 'LIKE', $search.'%')
			->execute();
		
		// Add the usernames to an array.
		$array = array();
		foreach ($users as $u)
		{
			$array[] = $u->username;
		}
		
		// Json encode it, and output it.
		$this->request->response = json_encode($array);
		
	}
	
	/**
	 * Validate that an user with the username exists, and set the field to the users id.
	 * @param Validate $array
	 * @param String   $field
	 */
	public function username_exists(Validate $array, $field)
	{
		
		$user = Jelly::select('user')
			->where('username', '=', $array[$field])
			->load();
		
		// If no user was found, give an error.
		if ( ! $user->loaded())
		{
			$array->error($field, 'incorrect');
			return;
		}
		
		$array['to_id'] = $user->id;
		
	}

} // End PM
