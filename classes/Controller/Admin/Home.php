<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Home extends Controller_Admin_Common{
	
	public function before(){
		parent::before();
		$this->styles = Arr::merge($this->styles,['select2/select2']);
		$this->scripts = Arr::merge($this->scripts,['jquery.min','select2/select2','admin/index']);
		}
	public function action_index(){
	
		}
		
	
	}
