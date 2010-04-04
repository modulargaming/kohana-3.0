<?php defined('SYSPATH') or die('No direct script access.');
/**
 *
 *
 * @package   Modular Gaming
 * @author    Curtis Delicata & Oscar Hinton
 * @copyright (c) 2010 Curtis Delicata & Oscar Hinton
 * @license   BSD - http://www.modulargaming.com/license
 */

class Controller_Forum_Category extends Controller_Frontend {
	
	public $protected = TRUE;
	public $title = 'Forum';
	
	public function before()
	{
		parent::before();	
		
		$this->category_id = Request::instance()->param('id');
		
		// If the category id was enterd, use view action instead of index.
		if ($this->category_id && $this->request->action == 'index')
			$this->request->action = 'view';
	}
	
	/**
	 * Display all categories
	 */
	public function action_index()
	{
		
		$categories = Jelly::select('forum_category')
			->execute();
	
		// Check if no categories was found.
		if ($categories->count() == 0)
		{
			// Set an error message.
			Message::set(Message::ERROR, 'No categories exist');
		}
	
		$this->template->content = View::factory('forum/index')
			->set('categories', $categories);
	
	}
	
	/**
	 * Display a specified category
	 */
	public function action_view()
	{
			
		$category = Jelly::select('forum_category')
			->where('id', '=', $this->category_id)
			->load();
	
		if ( ! $category->loaded())
		{
			Message::set( Message::ERROR, 'Invalid category' );
		}
	
		
		$this->title = 'Forum - '.$category->title;
		
		$topics = Jelly::select('forum_topic')
			->where('category_id', '=', $this->category_id)
			->execute();
	
	
		if ($topics->count() == 0)
		{
			Message::set( Message::ERROR, 'No topics exist' );
		}
	
		$this->template->content = View::factory( 'forum/category' )
			->set( 'category', $category )
			->set( 'topics', $topics );
	
	}
	
	/**
	* Create a new topic.
	*/
	public function action_new_topic($id)
	{
		
		$this->title = 'Forum - New Topic';
		
		$category = Jelly::select('forum_category')
			->where('id', '=', $id)
			->load();
		
		if ( ! $category->loaded())
		{
			die('CATEGORY NOT FOUND');
		}
		
		// Validate the form input
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->filter(TRUE, 'htmlspecialchars', array(ENT_QUOTES))
			->rule('title', 'not_empty')
			->rule('title', 'min_length', array(3))
			->rule('title', 'max_length', array(20))
			->rule('content', 'not_empty')
			->rule('content', 'min_length', array(5))
			->rule('content', 'max_length', array(1000));
		
		
		if ($post->check())
		{
			
			$topic_values = array(
				'title' => $post['title'],
				'user' => $this->user->id,
				'category' => $id,
				'status' => 'open',
				'posts' => '1',
			);
			
			
			$topic = Jelly::factory('forum_topic');
			
			// Assign the validated data to the sprig object
			$topic->set($topic_values);
			$topic->save();
			
			$topic_id = $topic->id;
			
			
			$post_values = array(
				'title' => $post['title'],
				'content' => $post['content'],
				'user' => $this->user->id,
				'topic' => $topic_id,
			);
			
			$message = Jelly::factory('forum_post');
			
			// Assign the validated data to the sprig object
			$message->set($post_values);
			$message->save();
			
			Message::set(Message::SUCCESS, 'You created a topic.');
			
			$this->request->redirect('forum/category/'.$id);
			
		}
		else
		{
			$this->errors = $post->errors('forum');
		}
		
		if ( ! empty($this->errors))
			Message::set(Message::ERROR, $this->errors);
		
		$this->template->content = View::factory('forum/new')
			->set('post', $post->as_array());

	}
	
}