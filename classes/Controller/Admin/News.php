<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin_News extends Controller_Admin_Common{
	
	public function action_index(){
		// get list
		$model_news = ORM::factory('News');//
		$pagination = Pagination::factory(array(
			'group' => 'admin',
			'total_items' => $model_news->count_all(),
			));
		$list = $model_news
			->order_by('time','DESC')
      ->offset($pagination->offset)
      ->limit($pagination->items_per_page)
      ->find_all()->as_array();
		$this->view
			->set('items',$list)
			->set('pagination',$pagination);
		}
	
	public function action_detail(){
		$id = $this->request->param('id');
		$model_news = ORM::factory('News',$id);
		if($model_news->loaded()){
			$this->view = View::factory('form/basic');
			$news = $model_news->as_array();
			$this->meta['title']=$news['title'];
			$form = $this->form($news);
			if($_POST && $form->check()){
				$data = Arr::extract($_POST, array('title', 'text'));
				$model_news->values($data);
				try{
					$model_news->save();
					$id_new = $model_news->pk();
					$this->view
						->set('form_show',false)
						->set('success',['id'=>$id_new,'title'=>$data['title']]);
					//if(isset($_POST['save'])) 
					HTTP::redirect('admin/news');
					//if(isset($_POST['apply'])) HTTP::redirect('admin/static/edit/'.$_id);
				}catch (ORM_Validation_Exception $e) {
					$errors = $e->errors('validation');
					}
				}
			}
		}
		
	public function action_new(){
		$form = $this->form($_POST);
		if($_POST && $form->check()){
			$data = Arr::extract($_POST, array('title', 'text', 'anons'));
			$model_news = ORM::factory('News')->values($data);
			try{
				$model_news->save();
				$id_new = $model_news->pk();
				if($id_new){
					$this->view
						->set('form_show',false)
						->set('success',['id'=>$id_new,'title'=>$data['title']]);
					}
				
				//if(isset($_POST['save'])) HTTP::redirect('admin/static');
				//if(isset($_POST['apply'])) HTTP::redirect('admin/static/edit/'.$_id);
			}catch (ORM_Validation_Exception $e) {
				$errors = $e->errors('validation');
				}
			Arr::log($_POST);
			}
		}
		
	private function form($data=[]){
			$this->scripts += ['ckeditor/ckeditor','ckeditor/adapters/jquery',];
			$this->view->bind('form',$form)->set('form_show',true);
			$form = Webform::factory('Admin_News',$data);
			return $form;
		}
	//public function form()
	
	}