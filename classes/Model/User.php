<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_User extends Model_Auth_User {

        protected $_has_many = array(
                'user_tokens' => array('model' => 'User_Token'),
                'roles'       => array('model' => 'Role', 'through' => 'roles_users'),
        );

	public function __isset($column){
		profilertoolbar::adddata($column);
		if(substr($column,0,3) == 'is_') return true;//$this->__isset(substr($column,3));
		if(substr($column,0,4) == 'not_') return $this->__isset(substr($column,4));
		return parent::__isset($column);
		}
	
	public function get($column){
		// check role
		if(substr($column,0,3) == 'is_'){
			$role_name = substr($column,3);
			$role_id_q = DB::select('role_id')->from('roles_users')->where('user_id','=',$this->id);//->where('role_id','NOT IN',[1,2]);
			return ORM::factory('Role')->where('id','IN',$role_id_q)->where('name','LIKE',$role_name)->count_all() > 0;
			}
		return parent::get($column);
		}

} // End User Model
