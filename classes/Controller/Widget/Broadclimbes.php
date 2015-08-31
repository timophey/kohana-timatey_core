<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Widget_Broadclimbes extends Controller_Widget{
	
	public $template = 'widget/broadclimbes';
	
	public function action_index(){
		$items = $this->item($this->initial);
		//echo"<script>console.dir(".json_encode($this->initial).")</script>";
		//echo"<script>console.dir(".json_encode($items).")</script>";
		//echo"<script>console.log(".sizeOf($items	).")</script>";
		if(sizeOf($items)<2) $this->auto_render = false; else
		$this->template->items = $this->item($this->initial);
		}
	private function item($data){
		if($dir = Arr::get($data,'directory')) $data['controller']=$dir.'_'.$data['controller'];
		$data += ['action'=>'index']; $action = Arr::get($data,'action');
		$parent = ['controller'=>'Main','directory'=>$dir,'action'=>'index']; $item=false;
		$controller_i18n = __($data['controller'].'_actions',[]);
		$title_i18n = (is_array($controller_i18n))?Arr::get($controller_i18n,$action):'';
		switch($data['controller']){
			// index
			case'Static':
				$item_data = DB::select('id','path','caption')->from('pages')->where('path','=',$data['params']['uri'])->execute()->as_array()[0]; //pages
				$item = ['title'=>$item_data['caption'],'link'=>$item_data['path'].'.html'];				
				break;
			case'Main':
				$item = ['title'=>'Главная','link'=>''];
				$parent = false;
				break;
			// Admin
			case'Admin_Static':
				switch($action){
					case'edit':
						$item_data = DB::select('id','caption')->from('pages')->where('id','=',$data['params']['id'])->execute()->as_array()[0]; //pages
						$item = ['title'=>$item_data['caption'],'link'=>'admin/static/'.$item_data['id']];
						$parent = ['controller'=>'Static'] + $parent;
						break;
					default:
						$item = ['link'=>'admin/static'];
						break;
					}				
				break;
			case'Admin_News':
				switch($action){
					case'new':
						$item = ['link'=>'admin/news/new'];
						$parent = ['controller'=>'News'] + $parent;
						break;
					case'detail':
						$item_data = DB::select('id','title')->from('news')->where('id','=',$data['params']['id'])->execute()->as_array()[0];
						$item = ['title'=>$item_data['title'],'link'=>'admin/news/'.$item_data['id']];
						$parent = ['controller'=>'News'] + $parent;
						break;
					case'index':
						$item = ['link'=>'admin/news'];
						$parent = ['controller'=>'Main'] + $parent;
						break;
					}
				break;						
		}
		// complete with i18n
		if($action = Arr::get($data,'action')){
			$title_i18n = Arr::get(__($data['controller'].'_actions',[]),$action);
			if($title_i18n && !Arr::get($item,'title')) $item['title'] = $title_i18n;
			}
		//echo"<script>console.dir(".json_encode($parent).")</script>";
		if($dir=="Payment"){
			//echo"<script>console.dir(".json_encode($data).")</script>";
			//exit;
			}
		$parent_item = ($parent)?$this->item($parent):[];
		//return;
		$return_items = ($item)?Arr::merge($parent_item,[$item]):[];
		return $return_items;
		}
	
	}