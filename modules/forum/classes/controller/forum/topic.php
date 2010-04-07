<?php defined('SYSPATH') or die('No direct script access.');
/**
 *
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    BSD - http://www.modulargaming.com/license
 */

class Controller_Forum_Topic extends Controller_Frontend {
	
	public $protected = TRUE;
	public $title = 'Forum - Topic';
	
	
	public function action_index($id)
	{

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
		
		
		$this->template->content = View::factory( 'forum/topic/view' )
			->set('topic', $topic)
			->set('posts', $posts);
	
	}


	/**
	* Create a new post.
	*/
	public function action_reply($id)
	{
		
		$topic = Jelly::select('forum_topic')
			->where('id', '=', $id)
			->load();
		
		// Make sure the topic exists
		if ( ! $topic->loaded())
		{
                        Message::set( Message::ERROR, 'Topic does not exist' );
                        $this->request->redirect('forum');
		}
		
		$this->title = 'Forum - Reply to '.$topic->title;
		
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
		
		$values = array(
			'title' => $post['title'],
			'content' => $post['content'],
			'user' => $this->user->id,
			'topic' => $id,
		);
		
		$message = Jelly::factory('forum_post');
		
		// Assign the validated data to the Jelly object
		$message->set($values);
		$message->save();
		
		
		$topic_id = $id;
		
		$topic = Jelly::select('forum_topic')
			->where('id', '=', $topic_id)
			->load();
		
		$topic->posts = $topic->posts+1;
		$topic->save();
		
		Message::set(Message::SUCCESS, 'You posted a new reply.');
		
		$this->request->redirect('forum/topic/'.$id);
		
		}
		else
		{
			$this->errors = $post->errors('forum');
		}
		
		if ( ! empty($this->errors))
			Message::set(Message::ERROR, $this->errors);
		
		$this->template->content = View::factory('forum/post/create')
			->set('post', $post->as_array());

	}



} // End Forum_Topic
