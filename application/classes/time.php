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
	
	public static function render($timestamp)
	{
		
		$timestamp += Time::$offset * 3600;
		
		return date(Time::$display, $timestamp);
		
	}
	
}