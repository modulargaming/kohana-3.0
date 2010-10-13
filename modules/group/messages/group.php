<?php defined('SYSPATH') or die('No direct script access.');
return array
(
	'name' => array(
		'not_empty' => 'Name cannot be empty',
		'min_length' => 'Name needs to be longer than 3 characters.',
		'max_length' => 'Name needs to be less than 20 characters.',

	),
	'description' => array(
		'not_empty'  => 'Description cannot be empty.',
		'min_length' => 'Description needs to be longer than 5 characters.',
		'max_length' => 'Description needs to be less than 500 characters.',
	),
);
