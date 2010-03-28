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
                $categories = Jelly::select( 'forum_category' )
                        ->execute();


                if ($categories->count() == 0)
{

                $message = 'No categories exist';
                Message::set( Message::ERROR, $message );

}

                $this->template->content = View::factory( 'forum/index' )
                        ->set( 'categories', $categories );

        }


	public function action_category ( $id )

	{

		$this->title = 'Forum - Category '."$id";

		if ( !is_numeric( $id ) ) 

		{

                $message = 'Invalid ID';
                Message::set( Message::ERROR, $message );

		}

		$topics = Jelly::select( 'forum_topic' )
			->where( 'category_id', '=', $id )
			->execute();

		
                if ($topics->count() == 0)
{

                $message = 'No topics exist';
                Message::set( Message::ERROR, $message );

}


		$this->template->content = View::factory( 'forum/category' )
			->set( 'topics', $topics );

	}



	public function action_topic( $id )
	{
		
		$this->title = 'Forum - Topic '."$id";
		
                if ( !is_numeric( $id ) ) 

                {

                $message = 'Invalid ID';
                Message::set( Message::ERROR, $message );

                }
		
		$posts = Jelly::select( 'forum_post' )
			->where( 'topic_id', '=', $id )
			->execute();

		

                if (!$posts)
{

                $message = 'Topic does not exist';
                Message::set( Message::ERROR, $message );

}

		$this->template->content = View::factory( 'forum/topic' )
			->set( 'posts', $posts );
		
	}
	

 public function action_post( $id )
 
{
$this->title = 'Forum - Post';

 
// Redirect the user to the forum topic
                                $this->request->redirect( 'forum/topic/' );

}
 



} // End Forum
