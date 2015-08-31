<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Перекрытие метода получения данных о структуре таблиц 
 *
 * @package	Kohana/ORM
 * @author Maxim Nagaychenko <maxnag [at] meta.ua>
 * @copyright  Maxim Nagaychenko
 * @filesource
 */
class ORM extends Kohana_ORM
{
	protected $_loaded_data;
	/**
	 * Кеширование структуры таблицы
	 * 
	 * @see Kohana_ORM::list_columns()
	 * @return array 
	 */
	public function list_columns()
	{
	    $cache_lifetime=10;
	    $cache_lifetime=360000; // 100 часов
	    $cache_key = $this->_db."_".$this->_table_name ."_structure";
	    $result = Cache::instance()->get($cache_key);
	    
	    if ($result) {
	        $columns_data = $result;
	    }
	 
	    if( !isset($columns_data)) {
	        $columns_data = $this->_db->list_columns($this->_table_name);
	        Cache::instance()->set($cache_key, $columns_data, $cache_lifetime);
	    }

	    return $columns_data;
	}
	
	public function get($column){
		//if(array_key_exists($column,$this->_loaded_data)) $this->_loaded_data[$column];//;return Arr::get()
		return $this->_loaded_data[$column] = parent::get($column);
		//return parent::get($column);
		}
}
