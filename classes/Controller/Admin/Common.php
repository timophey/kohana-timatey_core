<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Admin_Common extends Controller_Common{
	
	protected $menu_action = 'admin';
	protected $findtmpl_in = 'admin';

	protected $styles = ['admin'];
	public $template = 'main';
	
	public function before(){
		parent::before();
		$is_admin = $this->auth->logged_in('admin');
		if (!$is_admin){
			$this->sess->set('auth_ref',Request::initial()->uri());
//			throw new HTTP_Exception_403();
			HTTP::redirect('login');
			}
		//$this->template->cart = $this->widget_load('auth');
		//$this->template->cart_active = (sizeOf(Session::instance()->get('cart')) > 0);
		//$this->meta['title'] = $this->meta['caption'] = 'Административный раздел';
		}
	}
