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
	
	public function action_index( $id )
	{
		
		if ( !is_numeric( $id ) )
			die( 'Invalid thread ID' );
		
		$posts = Jelly::select( 'forum_post' )
			->where( 'topic_id', '=', $id )
			->execute();

/*		
		if ( $posts->topic_id != )
			die( ' ' );

*/

		$this->template->content = View::factory( 'forum/index' )
			->set( 'posts', $posts );
		
	}
	
} // End Forum
