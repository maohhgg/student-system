<?php

namespace Home\Controller;

class ArticleController extends HomeController {

    public function course($cctid = ''){
        $cctid = I('cctid');
        if($cctid){
            $lists = D('Question')->lists($cctid);
        } else {
            $lists = D('Question')->lists(null);
        }
       
        $api = new \Home\Api\QuestionApi();
        $lists = $api->int_to_string($lists);
        $this->assign('lists',$lists);//列表
        $this->assign('current', $cctid);
        $this->display("Index/index");
    }
    
    public function detail($id = 0){
        /* 标识正确性检测 */
		if(!($id && is_numeric($id))){
			$this->error('文档ID错误！');
		}

        /* 获取详细信息 */
		$api = new \Home\Api\QuestionApi();
		$lists = $api->detail($id,true);
		if(!$lists){
			$this->error($lists);
		}
        $this->assign('info', $lists);
        $this->assign('current', $lists['cctid']);
        $this->display();
    }

    public function add(){
        if(IS_POST){
            
        } else {
            if(!$this->auth()){
                $this->redirect("Empty/index");
            } 
            $user = session('user_auth');
            $api = new \Admin\Api\CCTApi;
            $lists = $api->lists(['teacher'=>$user['id']]);
            $this->assign("class",$lists);
            $this->display();
        }
    }
}