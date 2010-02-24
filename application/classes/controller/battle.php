<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Battle extends Controller_Frontend {
	
	public $protected = TRUE;
	public $title = 'Battle';
	
	public function before()
	{
		parent::before();
		
		// Load the character
		$this->user->character->load();
		
		// Check if the user has a character already.
		if ( !$this->user->character->loaded() )
			$this->request->redirect( 'character/create' );
			
		$this->user->character->battle->load();
		$this->user->character->battle->monster->load();
	}
	
	
	public function action_index()
	{
		$character = $this->user->character;
		$monster = $character->battle;
		
		$char = new Character( $this->user->character );
		
		if ( !$monster->id )
			$this->request->redirect( 'battle/new' );
		
		if ( !Battle::can_fight( $character ) or !Battle::can_fight( $monster ) )
			$this->request->redirect( 'battle/end' );
		
		$this->template->content = View::factory('battle/index')
			->set( 'char', $char )
			->set( 'character', $character )
			->set( 'monster', $monster );
	}
	
	public function action_attack()
	{
		
		$char = $this->user->character;
		$monster = $char->battle;
		
		if ( !Battle::can_fight( $char ) or !Battle::can_fight( $monster ) )
			$this->request->redirect( 'battle/end' );
		
		Battle::fight( $char, $monster );
		
		$this->request->redirect( 'battle' );
		
	}
	
	public function action_new()
	{
		
		$char = $this->user->character;
		$monster = $char->battle;
		
		if ( $monster->id )
			$this->request->redirect( 'battle' );
		
		$this->MG->new_battle( $char );
		
		$this->request->redirect( 'battle' );
	}
	
	public function action_end()
	{
		
		$character = $this->user->character;
		$battle = $character->battle;
		$monster = $battle->monster;
		
		if ( !$battle->id ) {
			$this->request->redirect( 'battle' );
		}
		
		if ( Battle::can_fight( $character ) and Battle::can_fight( $battle ) )
			$this->request->redirect( 'battle' );
		
		$char = new Character( $character );
		
		if ( $battle->hp <= 0 )
		{
			$view = 'won';
			
			$character->money = $character->money + $battle->monster->money;
			$character->xp = $character-xp + $monster->xp;
			
			$character->update();
		}
		else
		{
			$view = 'lost';
		}
		
		$this->template->content = View::factory( 'battle/' . $view )
			->set( 'money', $monster->money )
			->set( 'xp', $monster->xp );
		
		$battle->delete();
		
	}
	
	public function action_test()
	{
		
		$character = $this->user->character;
		$zone      = $character->zone;
		$monsters  = $zone->monsters;
		$offset    = rand( 1, $monsters->count() );
		
		
		
	}
	
	
} // End Battle
