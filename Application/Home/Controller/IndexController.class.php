<?php

namespace Home\Controller;

class IndexController extends HomeController {

    public function index(){
        $list = $this->lists('Question',['cctid'=>['gt',0]]);

        $api = new \Admin\Api\QuestionApi();
        $list = $api->int_to_string($list);
        $this->assign('lists',$list);// 赋值数据集
        $this->display();
    }
}