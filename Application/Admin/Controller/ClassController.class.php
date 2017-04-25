<?php
namespace Admin\Controller;

class ClassController extends AdminController{

    public function index(){
        $this->meta_title = '班级管理';
        $this->display();
    }
    public function add($grade='', $name='', $no='', $date='', $type=''){
        if(IS_POST){
             /* 调用新增接口新增班级 */
            $class   =   new ClassApi;
            $uid    =   $User->register($name, $password, $uid, $type, $cid, $date, $status);
            if(0 < $uid){ //注册成功
                $this->success('用户添加成功！',U('index'));
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        }
        $this->meta_title = '新增班级';
        $this->assign("_department",C('DEPARTMENT'));
        $this->display();
    }
}