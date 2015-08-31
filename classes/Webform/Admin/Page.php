<?php 

class Webform_Admin_Page extends Webform_ORM{
	
	public function meta(){
		return [
			'fields'=>[
				'content'=>[
					'class'=>'ckeditor'
				]
			],
			'options'=>[
				'model'=>'Page',
				'except_fields'=>[]
				]
			
			];
		}
	
	}
