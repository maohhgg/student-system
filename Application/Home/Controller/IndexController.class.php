<?php

namespace Home\Controller;

class IndexController extends HomeController {

    public function index(){
        $lists = D('Question')->lists(null);
        $api = new \Home\Api\QuestionApi();
        $lists = $api->int_to_string($lists);
        $this->assign('lists',$lists);//列表
        $this->display();
    }
}