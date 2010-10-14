<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Holds the events and rout specific stuffs for character module.
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */

// Add our events
Event::add('before', 'Character_Event::before');
Event::add('dashboard_left', 'Character_Event::dashboard_left');
Event::add('sidebar_left', 'Character_Event::sidebar_left');
Event::add('sidebar_right', 'Character_Event::sidebar_right');
