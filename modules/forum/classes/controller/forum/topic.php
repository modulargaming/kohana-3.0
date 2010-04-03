<?php defined('SYSPATH') or die('No direct script access.');
/**
*
*
* @package Modular Gaming
* @author Curtis Delicata
* @copyright (c) 2010 Curtis Delicata
* @license BSD - http://modulargaming.com/projects/modulargaming/wiki/License
*/

class Controller_Forum_Topic extends Controller_Frontend {

public $protected = TRUE;
public $title = 'Forum - Topic';



public function action_view( $id )

{

if ( ! is_numeric($id))
{
Message::set(Message::ERROR, 'Invalid ID');
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
public function action_add( $id )
{

$this->title = 'Forum - New Topic';

if ( ! is_numeric($id))
{
Message::set(Message::ERROR, 'Invalid ID');
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
//->callback($id, array($this, 'category_exists'))



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

Message::set(Message::SUCCESS, 'You created a topic.' );

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



        function valid_category( $form, $field )
        {
                
                $race = Jelly::select( 'forum_category' )
                        ->where( 'id', '=', $form[$field] )
                        ->load();
                
                if ( $race->loaded() )
                {
                        return true;
                }
                
                $form->error($field, 'category_not_valid');

        }
} // End Forum_Topic
