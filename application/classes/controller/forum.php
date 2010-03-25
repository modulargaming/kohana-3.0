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
/*

                if ( $categories->id != )
                        die( 'No categories exist' );
*/




                $this->template->content = View::factory( 'forum/index' )
                        ->set( 'categories', $categories );

        }


	public function action_category ( $id )

	{
		if ( !is_numeric( $id ) )
			die( 'Invalid thread ID' );
		
		$topics = Jelly::select( 'forum_topic' )
			->where( 'category_id', '=', $id )
			->execute();

		
/*

		if ( $topics->category != )
			die( 'No such category' );
*/


		$this->template->content = View::factory( 'forum/category' )
			->set( 'topics', $topics );

	}



	public function action_topic( $id )
	{
		
		if ( !is_numeric( $id ) )
			die( 'Invalid thread ID' );
		
		$posts = Jelly::select( 'forum_post' )
			->where( 'topic_id', '=', $id )
			->execute();

		
/*

		if ( $posts->topic != )
			die( 'No such thread' );
*/


		$this->template->content = View::factory( 'forum/topic' )
			->set( 'posts', $posts );
		
	}
	
} // End Forum
