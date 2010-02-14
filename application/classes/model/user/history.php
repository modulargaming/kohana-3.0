<?php defined('SYSPATH') or die('No direct script access.');
/**
*
*
* @package Modular Gaming
* @author Copy112
* @copyright (c) 2009 Copy112
* @license http://copy112.com/mg/license
*/
 
class Model_User_History extends Sprig {
 
protected $_sorting = array('time' => 'desc');
 
protected function _init()
{
$this->_fields += array(
'user' => new Sprig_Field_BelongsTo(array(
'model' => 'user',
'primary' => true,
)),
'time' => new Sprig_Field_Timestamp(array(
'empty' => TRUE,
'format' => 'Y-m-d H:i',
'auto_now_create' => true,
)),
'history' => new Sprig_Field_Char(),
);
}
 
}
