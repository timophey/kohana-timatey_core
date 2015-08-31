<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Widget_Menu extends Controller_Widget{
	
	protected $items;
	
	public function  before(){
		parent::before();
		$this->template->bind('items',$this->items);
		}
	public function action_top(){
			$this->items = [
				['title'=>'Главная','link'=>'','controller'=>'Main'],
				['title'=>'Каталог','link'=>'catalog','controller'=>'Catalog','children'=>$this->top_cat(0)],
				['title'=>'Оплата','link'=>'payment.html','controller'=>'Static'/*,'children'=>$this->top_cat()*/],
				['title'=>'Доставка','link'=>'delivery','controller'=>'Delivery'],
				['title'=>'Контакты','link'=>'contacts','controller'=>'Contacts'],
			];
		}
	public function action_cat(){
		/*$parent = $this->request->param('id') or $parent = 0;
		$items = $this->top_cat($parent)['items'];
		$this->items = ($items)?$items:false;*/
		}
	public function action_admin(){
			$this->items = [
				['title'=>'Страницы','link'=>'admin/static','controller'=>'Static'],
				['title'=>'Новости','link'=>'admin/news','controller'=>'News'],
				['title'=>'Пользователи','link'=>'admin/users','controller'=>'Users'],
				/*['title'=>'Заказы','link'=>'admin/order','controller'=>'Order','children'=>[
					'items'=>[
						['title'=>'Статистика','link'=>'admin/order/stat','controller'=>'Order','children'=>false],
						]
					]
				],
				['title'=>'Контакты','link'=>'contacts.html','controller'=>''],*/
			];
		}
	public function after(){
		//print_r($this->items);
		if($this->items){
			foreach($this->items as &$item){
				if(isset($item['controller'])){
					$item['active'] = ($item['controller'] == $this->initial['controller'])?true:false;
					if($this->initial['controller'] == 'Static' && $this->initial['directory'] !== 'Admin')
						$item['active'] = ($this->initial['uri'] == $item['link'])?true:false;
					}
				if(!isset($item['children'])) $item['children'] = false;
				//echo"{{$item['controller']}} == {{$this->initial['controller']}}";
				}
			}else $this->auto_render = false;
			
			//echo 
		//print_r($this->items);
		//print_r($this->initial);
		parent::after();
		}
	}