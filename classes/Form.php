<?php defined('SYSPATH') OR die('No direct script access.');

class Form extends Kohana_Form {

	/**
	 * Creates a form input. If no type is specified, a "text" type input will
	 * be returned.
	 *
	 *     echo Form::input('username', $username);
	 *
	 * @param   string  $name       input name
	 * @param   string  $value      input value
	 * @param   array   $attributes html attributes
	 * @return  string
	 * @uses    HTML::attributes
	 */
	public static function input($name, $value = NULL, array $attributes = NULL){ 
		$inputname = (Arr::get($attributes,'multiple') && !strpos($name,'[]')) ? $name.'[]' : $name;
		if($dataset = Arr::get($attributes,'dataset')) unset($attributes['dataset']);
		if(isset($attributes['type']) && isset($attributes['options']))
		 if(($attributes['type']=='radio' || $attributes['type']=='checkbox') && is_array($attributes['options'])){
			$options = $attributes['options']; $out = ''; $attributes['options']=false;// $checked=[];
			// make checked array
			if(is_array($value)){
				$checked = $value;
				}
			if(!is_array($value)){
				if($value === null) $checked = array();
				else{
					$checked = array((string)$value);
					}
				}
			//
			if(is_array($options)){
				foreach($options as $value=>$title){
					$id = $name.'_'.$value;
					$attrs = Arr::merge($attributes,['id'=>$id]);
					if(in_array($value,$checked))
						$attrs['checked']=true;
					if($dataset){
						if($data = Arr::get($dataset,$value)){
							if(is_array($data)) foreach($data as $datakey=>$datavalue) $attrs['data-'.$datakey] = $datavalue;
							}
						}
					$input = Kohana_Form::input($inputname, $value, $attrs);
					$label = Kohana_Form::label($id, $input.' '.$title);
					$out .=$label;//$input.
					}
				}
			return $out;
			}
		return Kohana_Form::input($inputname, $value, $attributes);
		}
	
	}