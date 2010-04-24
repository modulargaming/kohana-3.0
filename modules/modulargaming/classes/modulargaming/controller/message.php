<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @subpackage Core
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */

class Modulargaming_Controller_Message extends Controller_Frontend {

	public $title = 'Messages';
	public $protected = true;

	public function before()
	{
		parent::before();
		
		$this->sidebar[] = View::factory('message/sidebar');
	}
	
	/**
	 * Display the inbox.
	 */
	public function action_index()
	{
		
		$messages = Jelly::select('message')
			->where('to', '=', $this->user->id)
			->and_where('to_status', '<>', 'deleted')
			->execute();
		
		$this->template->content = View::factory('message/index')
			->set('sidebar', $this->sidebar)
			->set('messages', $messages);
	}
	
	/**
	 * Display the inbox.
	 */
	public function action_sent()
	{
		
		$messages = Jelly::select('message')
			->where('from', '=', $this->user->id)
			->and_where('from_status', '<>', 'deleted')
			->execute();
		
		$this->template->content = View::factory('message/sent')
			->set('sidebar', $this->sidebar)
			->set('messages', $messages);
	}
	
	/**
	 * Display the message.
	 * @param integer $id
	 */
	public function action_view($id)
	{
		
		if ( ! is_numeric($id) )
			die('Not numeric');
		
		$message = Jelly::select('message')
			->where('id', '=', $id)
			->load();
		
		// Make sure the user received or sent the message.
		if ($message->to->id != $this->user->id AND $message->from->id != $this->user->id)
		{
			Message::set(Message::ERROR, __('This is not your message.'));
			$this->request->redirect('message');
		}
		
		
		if ($message->to_status == 'new' && $message->to->id == $this->user->id)
		{
			$message->to_status = 'read';
			$message->save();
		}
		
		
		$this->template->content = View::factory('message/view')
			->set('sidebar', $this->sidebar)
			->set('message', $message);
	}
	
	/**
	 * Display the message.
	 * @param integer $id
	 */
	public function action_delete($id)
	{
		
		if ( ! is_numeric($id) )
			die('Not numeric');
		
		$message = Jelly::select('message')
			->where('id', '=', $id)
			->load();
		
		if ($message->to->id == $this->user->id)
		{
			if ($message->from_status == 'deleted')
			{
				$message->delete();
			}
			else
			{
				$message->to_status = 'deleted';
				$message->save();
			}
		}
		elseif ($message->from->id == $this->user->id)
		{
			if ($message->to_status == 'deleted')
			{
				$message->delete();
			}
			else
			{
				$message->from_status = 'deleted';
				$message->save();
			}
		}
		else
		{
			Message::set(Message::ERROR, __('This is not your message.'));
			$this->request->redirect('message');
		}
		
		Message::set(Message::SUCCESS, __('You deleted the message!'));
			
		$this->request->redirect('message');
		
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
			
			// Assign the validated data to the Jelly object
			$message->set($values);
			$message->save();
			
			Message::set(Message::SUCCESS, __('You sent away the message to :to!', array(':to' => $post['to'])));
			
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
	 * Retrieve usernames that start on the given parameter.
	 * @param string $search
	 */
	public function action_reciver($search)
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

} // End Message
