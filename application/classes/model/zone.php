<?php defined('SYSPATH') or die('No direct script access.');
/**
*
*
* @package Modular Gaming
* @author Copy112
* @copyright (c) 2010 Copy112
* @license http://copy112.com/mg/license
*/
 
class Model_Zone extends Sprig {
 
protected function _init()
{
$this->_fields += array(
'id' => new Sprig_Field_Auto,
'name' => new Sprig_Field_Char(),
'description' => new Sprig_Field_Text(),
 
'energy' => new Sprig_Field_Integer(),
 
'monsters' => new Sprig_Field_ManyToMany(array(
'model' => 'Monster',
'through' => 'zone_monster',
)),
 
'shops' => new Sprig_Field_HasMany(array(
'model' => 'Shop',
)),
);
}
 
}
