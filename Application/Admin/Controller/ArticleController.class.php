<?php
namespace Admin\Controller;

class ArticleController extends AdminController{

    public function index(){
        $this->meta_title = "内容管理";
        $this->display();
    }
}