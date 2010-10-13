<?php defined('SYSPATH') or die('No direct script access.');

/**
Route::set('group', 'group(/<controller>(/<id>(/<action>)))', array(
	'id' => '\d+',
))
**/
Route::set('group', 'group((/<id>(/<action>)))')

	->defaults(array(
		'directory'  => 'group',
		'controller' => 'groups',
		'action'     => 'index',
	));
