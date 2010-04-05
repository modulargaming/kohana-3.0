<?php defined('SYSPATH') or die('No direct script access.');
/**
 *
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    BSD - http://www.modulargaming.com/license
 */

class Controller_Forum_Post extends Controller_Frontend {
	
	public $protected = TRUE;
	public $title = 'Forum - Post';
	
	
	public function action_index($id)
	{

		$post = Jelly::select('forum_post')
			->where('id', '=', $id)
			->load();
		
		if ($post->loaded())
		{
			$this->title = 'Forum - '.$post->title;
		}
		else
		{
			Message::set(Message::ERROR, 'Post does not exist');
		}
		
		$this->template->content = View::factory( 'forum/post/view' )
			->set('post', $post);
	
	}


	public function action_edit($id)
	{
		$post = Jelly::select('forum_post')
                        ->where('id', '=', $id)
                        ->load();

                // Make sure the post exists
                if ( ! $post->loaded())
                {
                        Message::set( Message::ERROR, 'Post does not exist' );
                        $this->request->redirect('forum');
                }

		if ($this->user->id != $post->user->id)
                {
                        Message::set(Message::ERROR, 'You are not the author of this post.');

                        $this->request->redirect('forum');
                }

		else
		{
		$this->title = 'Forum - Edit '.$post->title;

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

                Message::set(Message::SUCCESS, 'Post has been edited.');

                        $this->request->redirect('forum');
                }

                $this->template->content = View::factory( 'forum/post/edit' )
                        ->set('post', $post);


	}

	}

	public function action_delete($id)
	{
	
	$post = Jelly::select('forum_post')
                        ->where('id', '=', $id)
                        ->load();

                if ($post->loaded())
                {
                        $this->title = 'Forum - Post - Delete';
                }
                else
                {
                        Message::set(Message::ERROR, 'Post does not exist');

			$this->request->redirect('forum');
                }


	if ($this->user->id != $post->user->id)
		{
                        Message::set(Message::ERROR, 'You are not the author of this post.');
			
			$this->request->redirect('forum');
		}

	else	{
		Jelly::factory('forum_post')->delete($id);
                Message::set(Message::SUCCESS, 'Post has been deleted.');
			
			$this->request->redirect('forum');
		}

		$this->template->content = View::factory( 'forum/post/delete' )
			->set('post', $post);


	}

} // End Forum_Post
