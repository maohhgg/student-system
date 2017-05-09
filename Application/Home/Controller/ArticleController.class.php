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

    public function change($id='',$title='', $description='', $content='', $qfid='', $afid='', $cctid='',$answer=''){
         if(IS_POST && $id){
            $api = new \Admin\Api\QuestionApi();
            $data = [
                'title' => $title,
                'description' => $description,
                'content' => $content,
                'qfid' => $qfid,
                'afid' => $afid,
                'cctid' => $cctid,
                'answer' => $answer,
            ];
            foreach($data as $key => $v){
                if (empty($v)) {
                    unset($data[$key]); //删除空的属性
                }
            }
            $info = $api->updateInfo($id, $data);
            if($info){
                $this->success('更新成功！',U('Article/detail',['id' => $id]));
            } else {
                $this->error($info);
            }
        } else {
            $user = is_login();
            $id = I('id');
            if(!$id || !$user){
                $this->redirect("Empty/index");
            }
            $api = new \Admin\Api\QuestionApi();
		    $lists = $api->detail($id);
           if($user['type']!=1){
                if($user['id'] != $lists['teacher_id']){
                     $this->error("你不是发布者，请勿修改",U("Index/index"));
                }
                $this->error("只有任课教师才可以发布作业",U("Index/index"));
            }
            $file = $api->file($lists);
            $api = new \Admin\Api\CCTApi;
            $list = $api->lists(['teacher'=>$user['id']]);
            $this->assign("class",$list);
            $this->assign("lists",$lists);
            $this->display('add');
        }
    }

}