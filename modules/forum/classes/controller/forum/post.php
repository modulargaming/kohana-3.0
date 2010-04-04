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
		
		$this->template->content = View::factory( 'forum/post' )
			->set('post', $post);
	
	}


} // End Forum_Post
