<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Battle extends Controller_Frontend {
	
	public $protected = TRUE;
	
	public function before()
	{
		parent::before();
		
		// Check so the user got a character
		if ( !$this->user->character )
			$this->request->redirect( 'character' );
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
		
		Battle::new_battle( $char, 1 );
		
		$this->request->redirect( 'battle' );
	}
	
	public function action_end()
	{
		
		$character = $this->user->character;
		$monster = $character->battle;
		
		if ( !$monster->id ) {
			$this->request->redirect( 'battle' );
		}
		
		if ( Battle::can_fight( $character ) and Battle::can_fight( $monster ) )
			$this->request->redirect( 'battle' );
		
		$char = new Character( $character );
		
		if ( $monster->hp <= 0 )
		{
			$view = 'won';
			
			$character->money = $character->money + $monster->monster->money;
			
			$character->update();
		}
		else
		{
			$view = 'lost';
		}
		
		$this->template->content = View::factory( 'battle/' . $view )
			->set( 'money', $monster->monster->money )
			->set( 'xp', $monster->monster->xp );
		
		$monster->delete();
		
	}
	
}