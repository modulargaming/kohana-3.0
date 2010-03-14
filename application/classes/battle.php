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
	public static function fight( $char, $monster )
	{
		
		$c_hp = $char->hp;
		$c_defence = 30;
		$c_dmg = 5;
		
		$m_hp = $monster->hp;
		$m_defence = $monster->monster->defence;
		$m_dmg = rand( $monster->monster->min_dmg, $monster->monster->max_dmg );
		
		
		$t = $c_hp;
		$t = round( $t - $m_dmg * ( ( 100 - $c_defence ) / 100 ) );
		
		$char->hp = $t;
		
		try
		{
			$char->save();
		}
		catch (Validate_Exception $e)
		{
			
			// Get the errors using the Validate::errors() method
			print_r( $e->array->errors('register') );
			die();
		}
		
		$t = $m_hp;
		$t = round( $t - $c_dmg * ( ( 100 - $m_defence ) / 100 ) );
		
		$monster->hp = $t;
		
		try
		{
			$monster->save();
		}
		catch (Validate_Exception $e)
		{
			
			// Get the errors using the Validate::errors() method
			print_r( $e->array->errors('register') );
			die();
		}
		
	}
	
}