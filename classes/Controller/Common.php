<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common extends Controller_Template {

	public $template = 'main';
	protected $widgets_folder = 'widget';
	protected $view;
	protected $sess;
	protected $auth;
	protected $user;
	protected $menu_action = 'top';
	protected $findtmpl_in = 'index';
	protected $meta = ['title'=>'','caption'=>''];
	protected $styles = [];
	protected $scripts = [];

	public function before(){
		parent::before();
		
		// global view, config
		
		$settings = Kohana::$config->load('common');
		View::set_global('host',$_SERVER['HTTP_HOST']);
		View::set_global('uri',Request::initial()->uri());
		View::set_global('base_url',URL::site());
		View::set_global('currency',$settings['currency']['icon']);
		
		
		$this->template
			->set('title',$settings->site_name)
			->set('description',$settings->site_description)
			->set('caption',"")
			->set('content',"")
			->set('styles',['default'])
			->set('scripts',[])//'jquery.min','scripts'
			->set('cart',"")
			->set('dclasses',"static")
			->set('year',date('Y'))
			;

		$controller = Request::current()->controller();
		$action = Request::current()->action();
		$dir = Request::initial()->directory();
		$templatemaybe = ["{$this->findtmpl_in}/$controller/$action",$this->findtmpl_in.'/'.$controller.'_'.$action];//print_r($templatemaybe);
		foreach($templatemaybe as $template){
		$template_file = APPPATH.'views/'.$template;
			if(file_exists($template_file.'.php') || file_exists($template_file.'.mustache')){
				$this->view = View::factory($template);
				$this->template->bind('content',$this->view);
				break;
				}
			}
		// meta
		$meta_controller = ($dir=Request::current()->directory())?$dir.'_'.$controller:$controller;
		/*if($title_i18n = Arr::get(__($meta_controller.'_actions',[]),$action)){
			$this->meta['title'] = $title_i18n;
			}*/
		// session
		$this->sess = Session::instance();
		// auth
		$this->auth = Auth::instance();
		$this->user = $this->auth->get_user();
		// permanent widgets
		$this->template->menu_top = $this->widget_load('menu/'.$this->menu_action);
		//$this->template->broadclimbes = $this->widget_load('broadclimbes');
		
		}
	public function after(){
		// append controller resources
		if($this->styles) $this->template->styles = Arr::merge($this->template->styles,$this->styles);
		if($this->scripts) $this->template->scripts = Arr::merge($this->template->scripts,$this->scripts);
		// complete style and script path
		foreach($this->template->styles as &$style) if(!preg_match("/\.css$/",$style)) $style = URL::site().'public/css/'.$style.'.css';
		foreach($this->template->scripts as &$style) if(!preg_match("/\.js$/",$style)) $style = URL::site().'public/js/'.$style.'.js';
		// complete meta
		if($this->meta['title']){
			if(!$this->meta['caption']) $this->meta['caption'] = $this->meta['title'];
			$this->template->title = $this->meta['title'].' - '.$this->template->title;
			}
		if($this->meta['caption']) $this->template->caption = $this->meta['caption'];
		$dir = Request::initial()->directory();
		// put under lamp
		switch($dir){
			case'Admin':
				// hello user form
				//$this->template->cart = $this->widget_load('auth');
				//$this->template->cart_active = $this->auth->logged_in();
				break;
			default:
				// add cart object
				//$this->template->cart = $this->widget_load('cart');//Request::factory($cart_uri)->execute();
				//$this->template->cart_active = (sizeOf(Session::instance()->get('cart')) > 0);
				break;
			}
		// profiler for debug
		//$this->template->profiler = View::factory('profiler/stats');
		// profilertoolbar
		$this->template->profilertoolbar = View::factory('profilertoolbar');
		// user form
		$this->template->auth_active = $this->auth->logged_in('login');
		$this->template->auth = $this->widget_load('auth');
		// debug
		if($this->request->param('request')=='inner'){
			$this->auto_render = false;
			$this->response->headers('Content-Type', 'application/json');  
			echo json_encode($this->template->content->as_array());
			}
		parent::after();
		}
    public function widget_load($widget)
    {
        return Request::factory($this->widgets_folder . '/' . $widget)->execute();
    }

} // End Common
