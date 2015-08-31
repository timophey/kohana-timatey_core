<?php 

class Webform_Admin_Pagenew extends Webform_ORM{
	
	public function meta(){
		return [
			'fields'=>[],
			'options'=>[
				'model'=>'Page',
				'except_fields'=>['content']
				]
			
			];
		}
	
	}
