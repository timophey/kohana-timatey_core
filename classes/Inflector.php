<?php defined('SYSPATH') or die('No direct script access.');

class Inflector extends Kohana_Inflector{
	
	public static function postfix($number, $one, $two, $five){
		if($number==1){
			$out=$one;
		}elseif($number>1 && $number<5){
			$out=$two;
		}elseif($number>=5 || $number==0){
			$out=$five;
		}
		return $out;
	}
	
	}