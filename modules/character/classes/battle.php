<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://modulargaming.com/license
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
		

		$c_random = rand(10,40);
		$c_dmg = $character->strength * $character->agility;
		$c_dmg = round($c_dmg / $c_random);
		
		$c_defence = $character->defense;
		
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
		
		$atk_names = array(
			'0' => "Red flux",
			'1' => "Transplant blast",
			'2' => "Dissolver",
			'3' => "Held Cutter",
			'4' => "Heated blast",
			'5' => "Inflated orb",
			'6' => "Energy mesh",
			'7' => "Energy kinesis",
			'8' => "Layered flux",
			'9' => "Delayed detonations"
		);
		
		// load attack names for user and foe
		$character_atk = $atk_names[rand(0, count($atk_names) - 1)];
		$monster_atk = $atk_names[rand(0, count($atk_names) - 1)];
		
		// Set an array of messages.
		$message = array(
			'You '.$character_atk.' which did '.$character_dmg.' damage.',
			'The '.$monster->name.' used '.$monster_atk.' which did '.$monster_dmg.' damage',
		);
		
		Message::set( Message::SUCCESS, $message );
		
	}
	
	
	public static function end( $battle )
	{
		
		$battle->delete();
		
	}
}
