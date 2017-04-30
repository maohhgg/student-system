<?php

namespace Home\Controller;

class ArticleController extends HomeController {

    public function course($cctid = ''){
        $cctid = I('cctid');
        if($cctid){
            $lists = $this->lists('Question',['cctid'=>$cctid]);
        } else {
            $lists =$this->lists('Question',['cctid'=>['gt',0]]);
        }
       
        $api = new \Admin\Api\QuestionApi();
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
		$api = new \Admin\Api\QuestionApi();
		$lists = $api->detail($id);
		if(!$lists){
			$this->error($lists);
		}
        $answer = D('answer')->info($id,true);
        $file = $api->file($lists);
        $this->assign('answer', $answer);
        $this->assign('info', $lists);
        $this->assign('file', $file);
        $this->assign('current', $lists['cctid']);

        $this->display();
    }

    public function add($title='', $description='', $content='', $qfid='', $afid='', $cctid='',$answer=''){
        if(IS_POST){
            $api = new \Admin\Api\QuestionApi();
            $info = $api->insert($title, $description, $content, $qfid, $afid, $cctid, $answer);
            if(is_numeric($info)){
                $this->success('添加成功！',U('Article/detail?id='.$info));
            } else {
                $this->error($info);
            }
        } else {
            $user = is_login();
            if(!$user){
                $this->redirect("Empty/index");
            }else if($user['type']!=1){
                $this->error("只有任课教师才可以发布作业",U("Index/index"));
            }
            $api = new \Admin\Api\CCTApi;
            $lists = $api->lists(['teacher'=>$user['id']]);
            $this->assign("class",$lists);
            $this->display();
        }
    }
}