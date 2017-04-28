<?php

namespace Home\Widget;
use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class CategoryWidget extends Action{
	
	
	public function lists($current=''){
		if(is_login()){
             $user = session('user_auth');
			 if($user['type'] == 2){
				 $api = new \User\Api\UserApi;
				 $category = $api->getCourse($user['id']);
			 } else {
				 $category = [
					 ['course' => "所有班级",],
				 ];
			 }
        }
		$this->assign('category', $category);
		$this->assign('current',$current);
		$this->display('Widget/lists');
	}
	
}
