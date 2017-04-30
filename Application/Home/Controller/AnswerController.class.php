<?php

namespace Home\Controller;

class AnswerController extends HomeController {

    public function index(){
        $user = is_login();
        if($user && $user['type'] == 1){
            $CCTId = D('ClassCourseTeacher')->where(['teacher'=>$user['id']])->field('id')->select();
            $CCTId = $this->_levelup($CCTId);
            $question = D('Question')->where(['cctid'=>['in',$CCTId]])->field('id,title')->select();
            $QId = $this->_levelup($question);
            $lists = $this->lists('Answer',['qid'=>['in',$QId],'score'=>-1]);
            $model = new \Admin\Api\AnswerApi;
            $lists = $model->int_to_string($lists);
            $this->assign("active",'active');
            $this->assign("lists",$lists);
            $this->display();
        } else {
            $this->rediect("Emtry/index");
        }
       
    }

    public function update($id='', $score =''){
        if(IS_POST){
            $user = is_login();
            if($user && $user['type'] == 1){
                if($score && $id){
                    $id = D("Answer")->where(['id'=>$id])->setField('score',$score);
                    $this->success($score);
                } else {
                    $this->error("没有接受到数据");
                }
            } 
        } else {
            $this->error("",U("Emtry/index"));
        }
    }

    public function readed(){
        $user = is_login();
        if($user && $user['type'] == 1){
            $CCTId = D('ClassCourseTeacher')->where(['teacher'=>$user['id']])->field('id')->select();
            $CCTId = $this->_levelup($CCTId);
            $question = D('Question')->where(['cctid'=>['in',$CCTId]])->field('id,title')->select();
            $QId = $this->_levelup($question);
            $lists = $this->lists('Answer',['qid'=>['in',$QId],'score'=>['gt',0]]);
            $model = new \Admin\Api\AnswerApi;
            $lists = $model->int_to_string($lists);
            $this->assign("lists",$lists);
            $this->assign("_active",'active');
            $this->display('index');
        } else {
            $this->rediect("Emtry/index");
        }
    }

    public function _levelup($data){
        if(!empty($data)){
            foreach($data as $key => $v){
                $data[$key] = $v['id'];
            }
        }
        return $data;
    }
}