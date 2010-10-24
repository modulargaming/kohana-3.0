<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */
class Modulargaming_Core {
	
	const VERSION = 0.66;
	const VERSION_URL = 'http://development.modulargaming.com/projects/modulargaming/repository/revisions/master/raw/version.txt';
	const VERSION_CACHE_TIME = 3600;
	
	public function __construct( $user )
	{
		$this->user = $user;
	}
	
	/**
	 * Adds a history item
	 * 
	 * @param string $history
	 * @return 
	 */
	public function add_history( $history )
	{
		
		$jelly = Jelly::factory( 'user_history' );
		
		$jelly->user = $this->user->id;
		$jelly->history = $history;
		
		try
		{
			$jelly->save();
		}
		catch (Validate_Exception $e)
		{
			die( 'Error in modulargaming class, add_history function validate' );
		}
		
	}
	
	
	/**
	 * Initializes a new battle for the character using the monsters id as the enemy.
	 *
	 * @param   object   Character
	 * @return  boolean
	 */
	public function new_battle( $char )
	{
		// Retrieve the monsters db info, so we can set hp etc.
		//$monster = Sprig::factory( 'monster', array( 'id' => $monster_id ) )->load();
		
		// TODO: Rewrite this to use mysql, Rand() and limit to 1.
		$zone = $char->zone;
		$monsters = $zone->get( 'monster' )
			->execute();
		
		$id      = rand( 1, $monsters->count() );
		$monster = $monsters;
		$monster = $monster[$id - 1];
		
		// Assign the data we need for the new battle row.
		$t = array(
			'character' => $char->id,
			'monster'   => $monster->id,
			'hp'        => $monster->max_hp,
		);
		
		// Add the row to the db.
		$jelly = Jelly::factory('battle');
		$jelly->set($t);
		
		try
		{
		    $jelly->save();
		    
		    $this->add_history( 'Started a new battle against ' . $monster->name );
		    
			return TRUE;
		}
		catch (Validate_Exception $e)
		{
		    print_r( $e->array->errors('blog/post') );
		}
		
		return FALSE;
		
	}
	
	
}
