<?php defined('SYSPATH') or die('No direct script access.');
/**
 *
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    BSD - http://modulargaming.com/projects/modulargaming/wiki/License
 */

class Controller_Forum extends Controller_Frontend {
	
	public $protected = TRUE;
	public $title = 'Forum';
	
	public function action_index ()
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

	
	public function action_category ( $id )
	{

		$this->title = 'Forum - Category '."$id";

		if ( !is_numeric( $id ) ) 
		{
			die('Invalid ID');
		}

		$topics = Jelly::select('forum_topic')
			->where('category_id', '=', $id)
			->execute();
		
		
		if ($topics->count() == 0)
		{
			Message::set( Message::ERROR, 'No topics exist' );
		}
		
		$this->template->content = View::factory( 'forum/category' )
			->set( 'topics', $topics );

	}
	
	
	
	public function action_topic( $id )
	{
		
		if ( ! is_numeric($id)) 
		{
			die('Invalid ID');
		}
		
		$topic = Jelly::select('forum_topic')
			->where('id', '=', $id)
			->load();
		
		if ($topic->loaded())
		{
			$this->title = 'Forum - '.$topic->title;
		}
		else
		{
			Message::set(Message::ERROR, 'Topic does not exist');
		}
		
		$posts = Jelly::select('forum_post')
			->where('topic_id', '=', $id)
			->execute();
		
		
		$this->template->content = View::factory( 'forum/topic' )
			->set('topic', $topic)
			->set('posts', $posts);
		
	}
	

	/**
	 * Create a new topic.
	 */
	public function action_new( $id )
	{
	
		$this->title = 'Forum - New Topic';
		
		
		// Validate the form input
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->callback('captcha', array($this, 'captcha_valid'))
			//->callback($id, array($this, 'category_exists'))
			->rule('title', 'not_empty')
			->rule('title', 'min_length', array(3))
			->rule('title', 'max_length', array(20))
			->rule('content', 'not_empty')
			->rule('content', 'min_length', array(5))
			->rule('content', 'max_length', array(1000));

		
		if ($post->check())
		{
			$topic_values = array(
				'title'    => $post['title'],
				'user'   => $this->user->id,
				'category' => $id,
				'created' => time(),
			);
			

			$post_values = array(
				'title'    => $post['title'],
				'content'  => $post['content'],
				'user'   => $this->user->id,
				'topic' => $topic_values->id,
				'created' => time(),
			);

			$topic = Jelly::factory('forum_topic');
			
			// Assign the validated data to the sprig object
			$topic->set($topic_values);
			$topic->save();

			
			$message = Jelly::factory('forum_post');
			
			// Assign the validated data to the sprig object
			$message->set($post_values);
			$message->save();
			
			Message::set(Message::SUCCESS, 'You created a topic.' );
			
			$this->request->redirect('forum');
			
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
	
	
	
	/**
	 * Create a new post.
	 */
	public function action_create( $id )
	{
	
		$this->title = 'Forum - Post';
		
		
		// Validate the form input
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->callback('captcha', array($this, 'captcha_valid'))
			//->callback($id, array($this, 'topic_exists'))
			->rule('title', 'not_empty')
			->rule('title', 'min_length', array(3))
			->rule('title', 'max_length', array(20))
			->rule('content', 'not_empty')
			->rule('content', 'min_length', array(5))
			->rule('content', 'max_length', array(1000));
		
		if ($post->check())
		{
			
			$values = array(
				'title'    => $post['title'],
				'content'  => $post['content'],
				'user'   => $this->user->id,
				'topic' => $id,
				'created' => time(),
			);
			
			$message = Jelly::factory('forum_post');
			
			// Assign the validated data to the sprig object
			$message->set($values);
			$message->save();
			
			Message::set(Message::SUCCESS, 'You posted a message.' );
			
			$this->request->redirect('forum');
			
		}
		else
        {
        	$this->errors = $post->errors('forum');
		}
		
		if ( ! empty($this->errors))
			Message::set(Message::ERROR, $this->errors);
		
		$this->template->content = View::factory('forum/create')
			->set('post', $post->as_array());

	}
	
	


	public function captcha_valid(Validate $array, $field)
	{
		if ( ! Captcha::valid($array[$field])) $array->error($field, 'invalid');
	}



	public function topic_exists(Validate $array, $field)
	{
		
		$topic = Jelly::select('forum_topic')
			->where('id', '=', $array[$field])
			->load();
		
		// If no topic was found, give an error.
		if ( ! $topic->loaded())
		{
			$array->error($field, 'incorrect');
			return;
		}

}	
	
} // End Forum
	
