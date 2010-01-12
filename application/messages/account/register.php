<?php defined('SYSPATH') or die('No direct script access.');
return array
(
	'username' => array(
		'not_empty' => 'Your username can not be empty',
	),
	'password' => array(
		'not_empty'  => 'Your password can not be empty',
		'min_length' => 'Your password need to be longer then 6 characters.',
	),
	'tos' => array(
		'not_empty' => 'You need to accept the Term Of Service',
	),
	'captcha' => array(
		'invalid' => 'Wrong verification code entered.',
	),
);