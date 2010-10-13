<?php defined('SYSPATH') or die('No direct script access.');

Route::set('group', 'group(/<controller>(/<id>(/<action>)))', array(
	'id' => '\d+',
))
	->defaults(array(
		'directory'  => 'group',
		'controller' => 'group',
		'action'     => 'index',
	));
