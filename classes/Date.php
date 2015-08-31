<?php defined('SYSPATH') OR die('No direct script access.');

class Date extends Kohana_Date {
	
	public static function time2post($timestring, $local_timestamp = NULL, $format = "%B"){
		//echo 'array("'.implode("','",Date::months(Date::MONTHS_LONG)).'");';
		$local_timestamp = ($local_timestamp === NULL) ? time() : (int) $local_timestamp;
		
		if(!is_numeric($timestring)){
			$t = preg_split("/[^\d]/",$timestring);
			$timestamp = mktime($t[3],$t[4],$t[5],$t[1],$t[2],$t[0]);
			}else $timestamp = (int) $timestring;
		
		// Determine the difference in seconds
		$offset = abs($local_timestamp - $timestamp);
		$offset_day = $timestamp - mktime(0,0,0,$t[1],$t[2],$t[0]);
		// text offsets
		if($offset <= Date::MINUTE){
			$span = 'Right now';
		}else{
			if($offset <= $offset_day){
				$span = 'Today at';
				}
			elseif($offset <= ($offset_day + Date::DAY)){
				$span = 'Yesterday at';
				}
			else{
				$span = $t[2];
				switch($format){
					case Date::MONTHS_LONG:
						$mon_str_all = array('','january','february','march','april','may','june','july','august','september','october','november','december');
						$mon_str = 'of '.$mon_str_all[(int) date('m',$timestamp)];
						$span .= ' '.__($mon_str).' ';
						break;
					case Date::MONTHS_SHORT:
						$span .= ' '.strftime($format,$timestamp);
						break;
					default:
						$span .='.'.date('m.Y',$timestamp);
						break;
					}
				}
			$span =__($span)." {$t[3]}:{$t[4]}";
			}
		
		return __($span);
		}
	}
