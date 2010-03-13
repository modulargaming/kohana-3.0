<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */
class Modulargaming_Core {
	
	public function __construct( $user )
	{
		$this->user = $user;
	}
	
	/**
	 * Ads a history item
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
	 * Initializes a new battle for the character using the monsters id as enemy.
	 *
	 * @param   object   Character
	 * @return  boolean
	 */
	public function new_battle( $char )
	{
		// Retrieve the monsters db info, so we can set hp etc.
		//$monster = Sprig::factory( 'monster', array( 'id' => $monster_id ) )->load();
		
		// TODO: Rewrite this to use mysql, Rand() and limit to 1.
		$zone      = $char->zone;
		$monsters  = $zone->monsters;
		$id        = rand( 1, $monsters->count() );
		$monster = $monsters->as_array();
		$monster = $monster[$id - 1];
		
		// Assign the data we need for the new battle row.
		$t = array(
			'character' => $char->id,
			'monster'   => $monster->id,
			'hp'        => $monster->max_hp,
		);
		
		// Add the row to the db.
		$sprig = Sprig::factory('battle');
		$sprig->values($t);
		
		try
		{
		    $sprig->create();
		    
		    $this->add_history( 'Started a new battle agains ' . $monster->name );
		    
			return TRUE;
		}
		catch (Validate_Exception $e)
		{
		    print_r( $e->array->errors('blog/post') );
		}
		
		return FALSE;
		
	}
	
	
	
	// Detect how long time it has been since the timestamp was created
	static public function ago($timestamp){
		
		$difference = time() - $timestamp;
		$periods = array( 'second', 'minute', 'hour', 'day', 'week', 'month', 'year' );
		$lengths = array( '60', '60', '24', '7', '4.35', '12', '100' );
		
		for( $j = 0; $difference >= $lengths[$j]; $j++ )
			$difference /= $lengths[$j];
		
		$difference = round($difference);
		if($difference != 1) $periods[$j].= "s";
			$text = "$difference $periods[$j] ago";
		
		return $text;
		
	}
	
}
