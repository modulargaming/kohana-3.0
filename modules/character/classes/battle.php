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
	 * Verify if the player/monster can fight.
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
	 * Verify if the player/monster can fight.
	 *
	 * @param   object   Character
	 * @return  boolean
	 */
	public static function fight( $character, $battle )
	{
		
		// TODO: Replace the temp variables with a correct math system to calculate them.
//		$c_defence = 30;
//		$c_dmg = 5;
		
		$c_dmg = $character->strength * $character->agility;
		$c_dmg = round($c_dmg /100);
		
		$c_defense = $character->defense;
		
		$monster = $battle->monster;
		
		// Check how much damage the monster will do on the character.
		$monster_dmg = rand( $monster->min_dmg, $monster->max_dmg );
		$monster_dmg = round( $monster_dmg * ( 100 - $c_defence ) / 100 );
		
		// Set the characters health
		$character->hp = $character->hp - $monster_dmg;
		
		// Make sure hp won't go below 0.
		if ($character->hp < 0)
		{
			$character->hp = 0;
		}
		
		$character->save();
		
		// Check how much damage the character should do on the monster.
		$character_dmg = round( $c_dmg * ( 100 - $monster->defence ) / 100 );
		
		// Set the monsters health
		$battle->hp = $battle->hp - $character_dmg;
		$battle->save();
		
		
		// Set an array of messages.
		$message = array(
			'You did '.$character_dmg.' damage.',
			'The foe did '.$monster_dmg.' damage',
		);
		
		Message::set( Message::SUCCESS, $message );
		
	}
	
	
	public static function end( $battle )
	{
		
		$battle->delete();
		
	}
}
