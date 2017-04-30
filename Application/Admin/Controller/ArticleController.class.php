<?php
namespace Admin\Controller;

class ArticleController extends AdminController{

    public function index($id=''){
        $api = new \Admin\Api\QuestionApi;
        $list = $this->lists('Question');
        $list = $api->int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = "内容管理";
        $this->display();
    }

    public function file(){
        $list = $this->lists('File');
        $list = D('File')->int_2_string($list);
        $this->assign('_list', $list);
        $this->meta_title = "全部文件";
        $this->display();
    }

    public function socre(){
        $list = $this->lists('Answer');
        $api = new \Admin\Api\AnswerApi;
        $list = $api->int_to_string($list);
        $this->meta_title = "全部成绩";
        $this->assign('_list', $list);
        $this->display();
    }
}