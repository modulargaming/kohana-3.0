<?php defined('SYSPATH') or die('No direct script access.');
return array
(
	'title' => array(
		'not_empty' => 'Title cannot be empty',
		'min_length' => 'Content needs to be longer than 3 characters.',
		'max_length' => 'Content needs to be less than 20 characters.',

	),
	'content' => array(
		'not_empty'  => 'Content cannot be empty.',
		'min_length' => 'Content needs to be longer than 5 characters.',
		'max_length' => 'Content needs to be less than 500 characters.',
	),
	'captcha' => array(
		'invalid' => 'Wrong verification code entered.',
	),
);
