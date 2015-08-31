<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller_Common{
	
	public function before(){
		parent::before();
		// Получаем статус ошибки
		$status = (int) $this->request->action();
		
		// Получаем сообщение об ошибке
		if (Request::$initial !== Request::$current){
			$message = rawurldecode($this->request->param('message'));
			/**/if ($message){
				$this->meta['title'] .=" ($message)";
				//$this->template->title = $message.' - '.$this->template->title;
				/*if($this->view)
					$this->view->message = $message;*/
			}else{
				//$this->request->action($status);
				}
			//$this->response->status($status);
			}
		//exit;
		}

    public function action_404(){}
    public function action_403(){}
    public function action_503()
		{
			//$this->template->title = 'Service Temporarily Unavailable';
		}
		public function action_500()
		{
			//$this->template->title = 'Internal Server Error';
		}
 	}