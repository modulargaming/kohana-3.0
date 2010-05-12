<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Holds the events and route specifics for Pet module.
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    http://www.modulargaming.com/license
 */

// Add our events
Event::add('before', 'Pet_Event::before');
Event::add('dashboard_right', 'Pet_Event::dashboard_right');
Event::add('sidebar_right', 'Pet_Event::sidebar_right');
