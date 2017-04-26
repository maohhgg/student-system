<?php
namespace Admin\Controller;
use Admin\Api\ClassApi;

class ClassController extends AdminController{

    public function index($id=''){
        $class  =  new ClassApi;
        if(IS_POST){
            /* 调用接口获取班级信息 */
            $list = $this->lists('Class',['type'=>$id,'status'=>1]);
            // print_r($list);
            if(!empty($list)){
                $list = $class->merge($list,array_keys(C('DEPARTMENT'))); 
            }
            $this->ajaxReturn($list);
        }
        $list = $this->lists('Class');
        $list = $class->merge($list,array_keys(C('DEPARTMENT')));
        $this->assign('_list', $list);
        $this->meta_title = '班级管理';
        $this->display();
    }

    public function add($grade='', $name='', $no='', $date='', $type='', $status=''){
        if(IS_POST){
             /* 调用新增接口新增班级 */
            $class   =   new ClassApi;
            $uid    =   $class->insert($grade, $name, $no, $date, $type, $status);
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

    /**
     * 获取添加时可能发生的错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    public function showRegError($code){
         switch ($code) {
            case -1:  $error = '所属系部不存在！'; break;
            case -2:  $error = '专业名不合法！'; break;
            case -3:  $error = '时间数据不合法！'; break;
            case -4:  $error = '年级数据不合法！'; break;
            case -5:  $error = '班号数据不合法！'; break;
            case -5:  $error = '班级状态不合法！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }
}