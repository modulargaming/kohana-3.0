<?php defined('SYSPATH') or die('No direct script access.');
/**
*
*
* @package Modular Gaming
* @author Copy112
* @copyright (c) 2009 Copy112
* @license http://copy112.com/mg/license
*/
 
class Controller_Zone extends Controller_Frontend {
 
public $title = 'Zone';
public $character = true;
 
public function action_index()
{
 
$zone = $this->char->zone;
$zone->load();
 
$shops = $zone->shops;
 
$this->template->content = View::factory( 'zone/index' )
->set( 'zone', $zone )
->set( 'shops', $shops );
 
 
}
 
 
}
