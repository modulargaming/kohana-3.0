<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Controller_Zone extends Controller_Frontend {
	
	public $title = 'Zone';
	public $load_character = TRUE;
	public $require_character = TRUE;
	
	public function action_index()
	{
		
		$zone = $this->character->zone;
		
		$shops = $zone->get('shops')->execute();
		$npcs = $zone->get('npcs')->execute();
		
		$this->template->content = View::factory( 'zone/index' )
			->set( 'zone', $zone )
			->set( 'shops', $shops )
			->set( 'npcs', $npcs );
		
		
	}
	
	
}