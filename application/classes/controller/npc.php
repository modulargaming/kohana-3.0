<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Controller_Npc extends Controller_Frontend {
	
	public $protected = TRUE;
	public $load_character = TRUE;
	public $require_character = TRUE;
	public $title = 'Npc';
	
	public function action_index( $id )
	{
		
		if ( !is_numeric( $id ) )
			die( 'id isnt numeric' );
		
		$npc = Jelly::select( 'npc' )
			->where( 'id', '=', $id )
			->load();
		
		if ( $npc->zone_id != $this->character->zone->id )
			die( 'not in your current zone' );
		
		$this->template->content = View::factory( 'npc/index' )
			->set( 'npc', $npc );
		
	}
	
} // End Npc