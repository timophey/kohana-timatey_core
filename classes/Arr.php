<?php defined('SYSPATH') OR die('No direct script access.');

class Arr extends Kohana_Arr {
	
	public static function to_config($array, $name){
		// make source
		$file_str = "<?php defined('SYSPATH') or die('No direct script access.');\n";
		$file_str.= "return array(\n".self::__process_array($array,1)."\n)\n";
		$file_str.= "?>";
		// save
		$filename = APPPATH.'config/'.$name.'.php';
		file_put_contents($filename,$file_str);
		}

	public static function __process_array($array,$indent=0){
	 $ret_str = ""; $first = true;
	 if($array) foreach($array as $key => $value){
		 if (!$first) $ret_str .= ",\n"; else $first = false; $ret_str .= str_repeat("\t",$indent);
			if (is_array($value)){      $ret_str .= "'$key' => array(\n".self::__process_array($value,$indent+1)."\n".str_repeat(" ",$indent).")";
			}elseif(is_string($value)){ $ret_str .= "'$key' => '$value'";
			}elseif(is_int($value)){    $ret_str .= "'$key' => $value";
			}elseif(is_bool($value)){   $ret_str .= "'$key' => ".($value?"true":"false");}
		}
	 return $ret_str;
	}
	
	public static function log($var){
		echo'<script>console.log('.(is_array($var)?''.json_encode($var).'':'"'.$var.'"').');</script>';
		}
	
	public static function rearray(){
		$a=func_get_args();
		if(is_array($a)){
			$s=array_shift($a);$n=array();$p='$n';
			for($i=sizeOf($a)-1;$i>=0;$i--)if(isset($s[0][$a[$i]]))$p.='[$row[\''.$a[$i].'\']]';$p.='=$row;';
			foreach($s as $row) eval($p);
			return $n;}
	}
	
	}
