<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller_Common{
	public function before(){
		parent::before();
//		$action = Request::initial()->action();
//		$action_i18n = __('auth_actions',[])[$action];
		//print_r($action_i18n);
		//$this->template->title = $action_i18n.' - '.$this->template->title;
		//$this->template->caption = $action_i18n;//.'/'.$action;
		}
	public function action_index(){
		if(Auth::instance()->logged_in()){
			$this->view->username = Auth::instance()->get_user()->username;
			$this->view->logout = '/logout';
			//$this->content = 'Добро пожаловать, '..'!';
      //$this->content.= '<br /><a href=\'logout\'>logout</a>';			
			}else{
				HTTP::redirect('login');
				}
		}
	public function action_register(){
		 if($_POST){
			 $model = ORM::factory('User');
			 $model->values(Arr::extract($_POST,['username','email','password','password_confirm']));
			 try{
				 $model->save();
				 $model->add('roles', ORM::factory('Role')->where('name', '=', 'login')->find());
				 //$this->request->redirect('member/view/');
				}catch (ORM_Validation_Exception $e){
					echo $e;
					}
			 }
			// а форма подцепится сама
		}
	public function action_login(){
		
		//Arr::log($this->user);
		// Смотрим, вдруг юзера прислали откуда-то
		if($ref = $this->request->referrer()) if($ref != $this->request->url() && !$this->sess->get('auth_ref')) $this->sess->set('auth_ref',$ref);
		// Проверям, вдруг пользователь уже зашел 
		if(Auth::instance()->logged_in()){
			//return HTTP::redirect('auth');
			}
		// Если же пользователь не зашел, но данные на страницу пришли, то: 
		if($_POST){
			$user = ORM::factory('User');
			$status = Auth::instance()->login($this->request->post('username'), $this->request->post('password'), true);// !!$this->request->post('remember')
			//echo"$status";
			if($status){
				$redirect_to = ($ref && $ref == Arr::get($_POST,'referrer'))?$ref:'admin';
				$this->sess->delete('auth_ref');
				//print_r([$ref,Arr::get($_POST,'referrer'),$redirect_to]);
				HTTP::redirect($redirect_to);
				}else{
					$this->content = 'failed';
				}
			}
		//print_r($this->view);
		//exit;
		$this->view->ref = $ref;
		//echo"ref = ".$this->view->ref;
		}
	public function action_logout(){
		if (Auth::instance()->logout()){
			$ref = $this->request->referrer();
			if($ref) return HTTP::redirect($ref);
			return HTTP::redirect('login');
			}else{
			$this->template->content = "fail logout";	
			}
		}
	
	}
