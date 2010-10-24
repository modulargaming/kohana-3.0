<?php defined('SYSPATH') or die('No direct script access.');
/**
 *
 *
 * @package   Modular Gaming
 * @category  Controllers
 * @author    Curtis Delicata
 * @copyright (c) 2010 Curtis Delicata
 * @license   BSD - http://www.modulargaming.com/license
 */

class Controller_Group_Groups extends Controller_Frontend {
	
	public $protected = TRUE;
	public $title = 'Group';
	
	public function before()
	{
		parent::before();	
		
		$this->group_id = Request::instance()->param('id');
		
		// If the group id was enterd, use view action instead of index.
		if ($this->group_id && $this->request->action == 'index')
			$this->request->action = 'view';
	}
	
	/**
	 * Display all groups
	 */
	public function action_index()
	{
		
		$groups = Jelly::select('group')
			->execute();
	
		// Check if no group were found.
		if ($groups->count() == 0)
		{
			// Set an error message.
			Message::set(Message::ERROR, 'No groups exist');
		}
	
		$this->template->content = View::factory('group/index')
			->set('groups', $groups);
	
	}
	
	/**
	 * Display a specified group
	 */
	public function action_view($id)
	{
			
		$group = Jelly::select('group')
			->where('id', '=', $this->group_id)
			->load();
	
		if ( ! $group->loaded())
		{
			Message::set( Message::ERROR, 'Invalid Group' );
		}
	
		
		$this->title = 'Group - '.$group->title;
		
		$group_users = Jelly::select('group_user')
			->where('group_id', '=', $this->group_id)
			->execute();
	
	
		if ($group_users->count() == 0)
		{
			Message::set( Message::ERROR, 'No users in this group' );
		}
	
		$this->template->content = View::factory( 'group/view' )
			->set( 'group', $group )
			->set( 'group_users', $group_users );
	
	}
	
	/**
	* Create a new group.
	*/
	public function action_new_group()
	{
		
		$this->title = 'Group - New Group';
		
		// Validate the form input
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->filter(TRUE, 'htmlspecialchars', array(ENT_QUOTES))
			->rule('name', 'not_empty')
			->rule('name', 'min_length', array(3))
			->rule('name', 'max_length', array(25))
			->rule('description', 'not_empty')
			->rule('description', 'min_length', array(5))
			->rule('description', 'max_length', array(1000));
		
		
		if ($post->check())
		{
			
			$group_values = array(
				'name' => $post['name'],
				'description' => $post['description'],
				'user' => $this->user->id,
				'status' => 'open',
			);
			
			
			$group = Jelly::factory('group');
			
			// Assign the validated data to the jelly object
			$group->set($group_values);
			$group->save();
			
			$group_id = $group->id;
			
			
			$group_user_values = array(
				'user' => $this->user->id,
				'group' => $group_id,
				'title' => 'owner'
			);
			
			
			$group_user = Jelly::factory('group_user');
			
			// Assign the validated data to the jelly object
			$group_user->set($group_user_values);
			$group_user->save();



			Message::set(Message::SUCCESS, 'You created a group.');
			
			$this->request->redirect('group/groups/'.$group_id);
			
		}
		else
		{
			$this->errors = $post->errors('group');
		}
		
		if ( ! empty($this->errors))
			Message::set(Message::ERROR, $this->errors);
		
		$this->template->content = View::factory('group/create')
			->set('post', $post->as_array());

	}

	
} // End Group_Groups
