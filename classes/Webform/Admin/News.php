<?php defined('SYSPATH') or die('No direct script access.');

class Webform_Admin_News extends Webform_ORM{
	public function meta(){
		return array(
			'fields'=>[
				'text'=>[
					'class'=>'ckeditor'
				],
				'anons'=>[
					'class'=>'ckeditor'
				],
			],
			'options'=>[
				'model'=>'News',
				'except_fields'=>['id'],//,'time'
				'valid_messages_file'=>'validation'
				],
			);
		}
}
