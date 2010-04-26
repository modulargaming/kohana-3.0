<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Modulargaming_Controller_Battle extends Controller_Frontend {
	
	public $protected = TRUE;
	public $load_character = TRUE;
	public $require_character = TRUE;
	public $title = 'Battle';	
	
	public function action_index()
	{
		
		$character = $this->character;
		$battle = $character->battle;
		
		$char = new Character( $character );
		
		// if the battle haven't started, start one.
		if ( !$battle->loaded() )
			$this->new_battle();
		
		// Check if the player and enemy can fight, if not end the battle.
		if ( !Battle::can_fight( $character ) or !Battle::can_fight( $battle ) )
			$this->request->redirect( 'battle/end' );
		
		$this->template->content = View::factory('battle/index')
			->set( 'char', $char )
			->set( 'character', $character )
			->set( 'battle', $battle )
			->set( 'monster', $battle->monster );
		
	}
	
	public function action_attack()
	{
		
		$character = $this->character;
		$battle = $character->battle;
		
		if ( !Battle::can_fight( $character ) or !Battle::can_fight( $battle ) )
			$this->request->redirect( 'battle/end' );
		
		Battle::fight( $character, $battle );
		
		$this->request->redirect( 'battle' );
		
	}
	
	public function action_run()
	{
		
		$character = $this->character;
		$battle = $character->battle;
		$monster = $battle->monster;
		
		// Check if the player and enemy can fight, if not end the battle.
		if ( !Battle::can_fight( $character ) or !Battle::can_fight( $battle ) )
			$this->request->redirect( 'battle/end' );
		
		// TODO: Write a math system that calculates the chances of escaping.
		
		Battle::end( $battle );
		
		$this->template->content = View::factory('battle/run/success')
			->set( 'character', $character )
			->set( 'monster', $monster );
		
		
	}
	
	public function new_battle()
	{
		$this->MG->new_battle( $this->character );
	}
	
	public function action_end()
	{
		
		$character = $this->character;
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
			$character->xp = $character->xp + $monster->xp;
			$character->save();

			if($character->xp >= 100)
			{
			$character->xp == $character->xp - 100;
			$character->level == $character->level++;
			$character->save();
			}
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
	
	
} // End Battle
