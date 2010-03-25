<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Battle {	
	
	/**
	 * Verifies if the player/monster can fight.
	 *
	 * @param   object   Character
	 * @return  boolean
	 */
	public static function can_fight( $char )
	{
		
		if ( $char->hp <= 0 )
			return FALSE;
			
		return TRUE;
		
	}
	
	
	/**
	 * Verifies if the player/monster can fight.
	 *
	 * @param   object   Character
	 * @return  boolean
	 */
	public static function fight( $character, $battle )
	{
		
		$c_hp = $character->hp;
		$c_defence = 30;
		$c_dmg = 5;
		
		
		$monster = $battle->monster;
		
		// Check how much dmg the monster should do on the character.
		$monster_dmg = rand( $monster->min_dmg, $monster->max_dmg );
		$monster_dmg = round( $monster_dmg * ( 100 - $c_defence ) / 100 );
		
		// Set the characters health
		$character->hp = $character->hp - $monster_dmg;
		$character->save();
		
		// Check how much dmg the character should do on the monster.
		$character_dmg = round( $c_dmg * ( 100 - $monster->defence ) / 100 );
		
		// Set the monsters health
		$monster->hp = $monster->hp - $character_dmg;
		$monster->save();
		
		
		// Set an array of messages.
		$message = array(
			'You did '.$character_dmg.' damage.',
			'The foe did '.$monster_dmg.' damage',
		);
		
		Message::set( Message::SUCCESS, $message );
		
	}
	
}