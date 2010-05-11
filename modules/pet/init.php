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
Event::add('dashboard-left', 'Pet_Event::dashboard');
Event::add('sidebar', 'Pet_Event::sidebar');
