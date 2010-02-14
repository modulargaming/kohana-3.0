<?php defined('SYSPATH') or die('No direct script access.');
/**
*
*
* @package Modular Gaming
* @author Copy112
* @copyright (c) 2010 Copy112
* @license http://copy112.com/mg/license
*/
 
class ModularGaming {
 
public function __construct( $user )
{
$this->user = $user;
}
 
 
public function add_history( $history )
{
 
$sprig = Sprig::factory( 'user_history' );
 
$sprig->user = $this->user->id;
$sprig->history = $history;
 
try
{
 
$sprig->create();
 
}
catch (Validate_Exception $e)
{
die( 'Error in modulargaming class, add_history function validate' );
}
 
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
