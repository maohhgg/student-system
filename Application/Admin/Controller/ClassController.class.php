<?php
namespace Admin\Controller;

class ClassController extends AdminController{

    public function index(){
        $this->meta_title = '班级管理';
        $this->display();
    }
}