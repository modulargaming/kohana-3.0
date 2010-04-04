<?php defined('SYSPATH') or die('No direct script access.');

Route::set('forum', 'forum(/<controller>(/<id>(/<action>)))', array(
	'id' => '\d+',
))
	->defaults(array(
		'directory'  => 'forum',
		'controller' => 'category',
		'action'     => 'index',
	));
