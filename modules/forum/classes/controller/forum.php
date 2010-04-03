<?php defined('SYSPATH') or die('No direct script access.');
/**
*
*
* @package Modular Gaming
* @author Curtis Delicata
* @copyright (c) 2010 Curtis Delicata
* @license BSD - http://modulargaming.com/projects/modulargaming/wiki/License
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

if ( ! is_numeric($id))
{
Message::set(Message::ERROR, 'Invalid ID');
}

$category = Jelly::select('forum_category')
->where('id', '=', $id)
->load();

if ( ! $category->loaded())

{
Message::set( Message::ERROR, 'Invalid category' );
}


$topics = Jelly::select('forum_topic')
->where('category_id', '=', $id)
->execute();


if ($topics->count() == 0)
{
Message::set( Message::ERROR, 'No topics exist' );
}

$this->template->content = View::factory( 'forum/category' )
->set( 'category', $category )
->set( 'topics', $topics );

}


public function category_exists(Validate $array, $field)
{

$category = Jelly::select('forum_category')
->where('id', '=', $array[$field])
->load();

// If no category was found, give an error.
if ( ! $category->loaded())
{
$array->error($field, 'incorrect');
return;
}

} 


}
