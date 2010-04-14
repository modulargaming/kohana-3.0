<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Time {	
	
	public static $offset = 0;
	public static $display = 'Y-m-d  H:i';
	
	/**
	 * Return the timestamp with the user's timezone and his display options.
	 * @param integer $timestamp time in seconds
	 * @param integer $ago_days  number of days to display x day(s) ago formating
	 */
	public static function date($timestamp, $ago_days = 2)
	{
		
		if ($timestamp < time() + (Date::DAY * $ago_days))
		{
			return Time::ago($timestamp);
		}
		
		$timestamp += Time::$offset * 3600;
		
		return date(Time::$display, $timestamp);
		
	}
	
	/**
	 * Return the time since the timestamp was created nicely formatted.
	 * @param integer $timestamp  time in seconds
	 */
	static public function ago($timestamp){
		
		$difference = time() - $timestamp;
		$periods = array( 'second', 'minute', 'hour', 'day', 'week', 'month', 'year' );
		$lengths = array( '60', '60', '24', '7', '4.35', '12', '100' );
		
		for( $j = 0; $difference >= $lengths[$j]; $j++ )
			$difference /= $lengths[$j];
		
		$difference = round($difference);
		if($difference != 1) $periods[$j].= "s";
			$text = $difference.' '.__($periods[$j]).' '.__('ago');
		
		return $text;
		
	}
	
}