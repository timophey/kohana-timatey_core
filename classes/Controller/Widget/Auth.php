<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Widget_Auth extends Controller_Widget{

    public function action_index()
    {
        $auth = Auth::instance();
        $logged_in = $auth->logged_in('login');
        $this->template->auth = $auth;
        $this->template->user = $auth->get_user();
       // $this->template->log_in_url = Kohana::$config->load('auth.log_in_url');
       ($logged_in)?$this->template->logged_in = true:$this->template->logged_out = true;
    }
	
	}