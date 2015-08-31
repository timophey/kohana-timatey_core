<?php defined('SYSPATH') or die('No direct script access.');
 
abstract class Controller_Widget extends Controller{//_Template
	
	public $initial;
	public $template;
	public $auto_render = true;
	
	public static function load($name){
		$classname = 'Controller_Widget_'.ucwords($name);
		$class = new $classname;
		//return new
		//return Request::factory($this->widgets_folder . '/' . $widget)->execute();
		
		}

	public function  before() {
		parent::before();
			//if(Request::current()->is_initial()) $this->auto_render = FALSE;
         $widget_name = Request::current()->controller();       // название виджета
         $controller = Request::initial()->controller();    // контроллер
         $action = Request::initial()->action();            // экшен
         $this->template = View::factory('widget/'.strtolower(Request::current()->controller()));
         //echo"<script>console.log('".'widget/'.strtolower(Request::current()->controller())."')</script>";

         $this->initial = [
					'controller'=>$controller,
					'directory'=>Request::initial()->directory(),
					'action'=>$action,
					'params'=>Request::initial()->param(),
					'uri'=>Request::initial()->uri(),
         ];
		//print_r($this->initial);
		}
	public function after(){
		if ($this->auto_render === TRUE)
			$this->response->body($this->template->render());
    parent::after();		
		}

	}