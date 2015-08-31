<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Static extends Controller_Admin_Common{
	
	/*public function before(){
		parent::before();
		
		//$this->meta['title'] = "Страницы - ".$this->meta['title'];
		//$this->meta['caption'].= " - Страницы";
		//$this->template->styles = Arr::merge($this->template->styles,['select2/select2']);
		//$this->template->scripts = Arr::merge($this->template->scripts,['jquery.min','select2/select2','admin/index']);
		
		}*/
	public function action_index(){
		$_page = new Model_Page();

		if(isset($_POST['add'])){
			$data = Arr::extract($_POST, array('path', 'title', 'keywords', 'description', 'caption'));
			$_page->values($data);
			try{
				$id = $_page->save()->pk();
				HTTP::redirect('admin/static/edit/'.$id);
			}catch (ORM_Validation_Exception $e) {
				$errors = $e->errors('validation');
				}
			}

		$list = $_page->find_all()->as_array();
		$this->view->items = $list;
		// new page form
		$form = Webform::factory('Admin_Pagenew');
		$this->view->form = $form;/**/
		}
	public function action_edit(){
		$_id = $this->request->param('id');
		$_page = new Model_Page($_id);
		$content = $_page->as_array();
		if(isset($_POST['apply']) || isset($_POST['save'])){
			$data = Arr::extract($_POST, array('path', 'title', 'keywords', 'description', 'caption', 'content'));
			$_page->values($data);
			try{
				$_page->update();
				if(isset($_POST['save'])) HTTP::redirect('admin/static');
				if(isset($_POST['apply'])) HTTP::redirect('admin/static/edit/'.$_id);
			}catch (ORM_Validation_Exception $e) {
				$errors = $e->errors('validation');
				}
			}
		// make form
		$this->scripts = ['ckeditor/ckeditor','ckeditor/adapters/jquery',];
		$form = Webform::factory('Admin_Page',$content);
		$this->view->form = $form;
		// return meta
		$this->meta['title'] = $content['title'];
		}
	public function action_delete(){
		$_id = $this->request->param('id');
//		if($_id && Arr::get($_POST,'sure')){
			$_page = new Model_Page($_id);
			$_page->delete();
			HTTP::redirect('admin/static');
//			}
		}
	
	}
