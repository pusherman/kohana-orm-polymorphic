<?php defined('SYSPATH') or die('No direct script access.');

class ORM extends Kohana_ORM 
{
  protected $has_many_polymorphic = array();

  public function __get($column) 
  {
    if (isset($this->has_many_polymorphic[$column]) &&  ! isset($this->_related[$column])) 
    {
      return ORM::factory(inflector::singular($column))
       ->where($this->polymorphic_field_id($column), '=', $this->_object[$this->_primary_key])
       ->where($this->polymorphic_field_object($column), '=', inflector::singular($this->_table_name))
       ->find_all();
    }

    return parent::__get($column);
  }

  protected function polymorphic_field_id($column) 
  { 
    return $this->has_many_polymorphic[$column] .'_id';
  }

  protected function polymorphic_field_object($column) 
  {
    return $this->has_many_polymorphic[$column] .'_type';
  }
}
