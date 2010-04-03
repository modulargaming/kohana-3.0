<?php defined('SYSPATH') or die('No direct script access.');
/**
*
*
* @package Modular Gaming
* @author Curtis Delicata
* @copyright (c) 2010 Curtis Delicata
* @license BSD - http://modulargaming.com/projects/modulargaming/wiki/License
*/

class Controller_Forum_Post extends Controller_Frontend {

public $protected = TRUE;
public $title = 'Forum - Post';

public function action_view( $id )
{

if ( ! is_numeric($id))
{
Message::set(Message::ERROR, 'Invalid ID');
}

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


/**
* Create a new post.
*/
public function action_add( $id )
{

$this->title = 'Forum - New Post';

if ( ! is_numeric($id))
{
Message::set(Message::ERROR, 'Invalid ID');
}


// Validate the form input
$post = Validate::factory($_POST)
->filter(TRUE,'trim')
->filter(TRUE, 'htmlspecialchars', array(ENT_QUOTES))
//->callback('captcha', array($this, 'captcha_valid'))
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
'title' => $post['title'],
'content' => $post['content'],
'user' => $this->user->id,
'topic' => $id,
);

$message = Jelly::factory('forum_post');

// Assign the validated data to the sprig object
$message->set($values);
$message->save();


$topic_id = $id;

$topic = Jelly::select('forum_topic')
->where('id', '=', $topic_id)
->load();

$topic->posts = $topic->posts+1;
$topic->save();

Message::set(Message::SUCCESS, 'You posted a message.' );

$this->request->redirect('forum/topic/'.$id);

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


} // End Forum_Post
