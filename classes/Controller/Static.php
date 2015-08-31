<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Static extends Controller_Common{
	
	public function action_index(){
			
			
			$uri = $this->request->detect_uri();
			$_page = $this->request->param('uri');
//			if(preg_match("/([a-z0-9_]+)\.html/i",$uri,$_uri)){
//				$path = $_uri[1];
				$path = $this->request->param('uri');
				//$tmpl = &$this->template;
				//$content = $_page->where('path','like',$path)->find()->as_array();
				$_page = $this->load_page($path);
				
				if($_page->loaded()){
					$content = $_page->as_array();
					foreach($content as $k=>$v) if($v){
						if($k == 'title'){
							$this->template->set($k,$v.' - '.$this->template->title);
						}else{
							$this->template->set($k,$v);
							}
						}
					}else $this->template->content = "Страница не найдена";
//				}
		}
	public static function load_page($alias){
			$_page = new Model_Page();
			$content = $_page->where('path','like',$alias)->find();//->as_array();
			return $_page;
		}
	
	}