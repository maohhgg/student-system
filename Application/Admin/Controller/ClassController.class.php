<?php
namespace Admin\Controller;
use Admin\Api\ClassApi;
use Admin\Api\CCTApi;

class ClassController extends AdminController{

    public function index($id='', $all = ""){
        $class  =  new ClassApi;
        if(IS_POST){
            /* 调用接口获取班级信息 */
            $map['type'] = $id;
            if($all !== 'true'){
                $map['status'] = 1;
            }
            $list = $this->lists('Class',$map);
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

    /**
     * 状态修改
     */
    public function changeStatus($method=null, $id='', $grade='', $name='', $no='', $date='', $type='', $status=''){
        if(empty($method) && !IS_POST){
            $id = I('id');
            $api = new ClassApi;
            $class = $api->info($id,false);
            $this->assign("_department",C('DEPARTMENT'));
            $this->assign("_class",$class);
            $this->meta_title = '班级管理';
            $this->display('add');
        } else if(IS_POST && $id) {
            $class   =   new ClassApi;
             $data = [
                'grade' => $grade,
                'name' => $name,
                'no' => $no,
                'date' => $date,
                'type' => $type,
                'status' => $status,
            ];
            foreach($data as $key => $v){
                if (empty($v)) {
                    unset($data[$key]); //删除空的属性
                }
            }
            $uid    =   $class->updateInfo($id,$data);
            if(0 < $uid){ //修改成功
                $this->success('修改成功！',U('index'));
            } else { //修改失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
            $id = array_unique((array)I('id',0));

            $id = is_array($id) ? implode(',',$id) : $id;
            if ( empty($id) ) {
                $this->error('请选择要操作的数据!');
            }
            $map['uid'] =   array('in',$id);
            switch ( strtolower($method) ){
                case 'forbid':
                    $this->forbid('Member', $map );
                    break;
                case 'update':
                    $this->resume('Member', $map );
                    break;
                case 'delete':
                    $this->delete('Member', $map );
                    break;
                default:
                    $this->error('参数非法');
            }
        }
    }

    public function have($method=null, $name='', $tag=''){
        $class = new ClassApi();
        $id = I('class');
        if(!empty($id)){
            $map['cid'] = $id;
            $this->meta_title = $class->info($id)['text'].' 所有课程';
            $list = $this->lists('ClassCourseTeacher',['class'=>$id]);
            $cct = new CCTApi;
            $list = $cct->int_2_string($list);
            $this->assign("_list",$list);
            $this->assign("cid",$id);
            $this->display();
        } else {
            $this->redirect("Class/course");
        }
    }

    public function course($method=null, $name='', $tag=''){
        if(IS_POST){
            $couser   =   new CouserApi;
            $uid   =  $couser->insert($name, $tag);
            if(is_numeric($uid)){ //注册成功
                $this->success('添加成功！',U('index'));
            } else {
                $this->error($uid); //错误详情见自动验证注释
            }
        } else if(!empty($method)) {
            $this->meta_title = '课程管理';
            switch ( strtolower($method) ){
                case 'add':
                    $this->display('course_add');
                break;
                case 'delete':
                    if(I('id')){
                        M('Course')->delete(I('id'));
                    }
                    break;
                default:
                    $this->error('参数非法');
            }
            
        } else {
            $list = $this->lists('Course');
            $this->assign('_list', $list);
            $this->meta_title = '所有课程';
            $this->display();
        }
       
    }

    public function classcourse($class='', $course='', $teacher='', $start='', $end='', $status=''){
        if (IS_POST){
            $cct = new CCTApi();
            $uid = $cct->insert($class, $course, $teacher, $start, $end, $status);
            if(is_numeric($uid)){ //注册成功
                $this->success('添加成功！',U(''));
            } else {
                $this->error($uid); //错误详情见自动验证注释
            }
        }
        $id = I('id');
        if(!empty($id)){
            $class = new ClassApi();
            $class = $class->info($id)['text'];
            $this->meta_title =  $class.' 添加课程';
            $course = $this->lists('Course');
            $this->assign('_course', $course);
            $teacher = $this->lists('User',['type'=>1]);
            $this->assign('_teacher', $teacher);
            $this->assign('_cid', $id);
            $this->assign("_class", $class);
            $this->display();
        } else {
            $this->redirect("Class/course");
        }
       
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