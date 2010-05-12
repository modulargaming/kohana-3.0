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
Event::add('dashboard-left', 'Character_Event::dashboard');
Event::add('sidebar_right', 'Character_Event::sidebar_right');
