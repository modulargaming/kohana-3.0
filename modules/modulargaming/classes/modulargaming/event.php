<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */
class Modulargaming_Event {
	public static function sidebar_right()
	{
		$s = Event::$data;

                if ( ! $s->user)
                {
                        return false;
                }

                Character_Event::load_character($s);

                $s->sidebar_right[] = View::factory('character/sidebar')
                                ->set('character', $s->character)
                                ->set('char', new Character($s->character));


        }

}