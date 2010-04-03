<?php defined('SYSPATH') or die('No direct script access.');

/**
* Set the routes. Each route must have a minimum of a name, a URI and a set of
* defaults for the URI.
*/ 

Route::set('topic', 'forum/topic/<id>', array(
'id' => '\d+',
))
->defaults(array(
		'directory'  => 'forum',
		'controller' => 'topic',
		'action' => 'view',
));
 
Route::set('post', 'forum/post/<id>', array(
'id' => '\d+',
))
->defaults(array(
                'directory'  => 'forum',
		'controller' => 'post',
		'action' => 'view',
));

Route::set('topic/add', 'forum/category/<id>/new_topic', array(
'id' => '(\w|[-])+',
))
->defaults(array(
                'directory'  => 'forum',
		'controller' => 'topic',
		'action' => 'add',
));

Route::set('post/add', 'forum/topic/<id>/new_post', array(
'id' => '(\w|[-])+',
))
->defaults(array(
                'directory'  => 'forum',
		'controller' => 'post',
		'action' => 'add',
));

/**
Route::set('post', 'post(/<action>(/<id>))', array(
'action' => '\w+',
'id' => '\d+',
))
->defaults(array(
'controller' => 'post',
));
**/


// the default entry
Route::set('forum', '(/<controller>(/<action>(/<id>)))', array(
'controller' => '\w+',
'action' => '\w+',
'id' => '\d+',
))
->defaults(array(
//'directory' => 'forum',
'controller' => 'forum',
'action' => 'index',
));
