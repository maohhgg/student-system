<?php
namespace Admin\Controller;
use User\Api\UserApi as UserApi;
use Admin\Api\ClassApi as ClassApi;


class UserController extends AdminController {

    public function index(){
        $list   = $this->lists('User');
        int_to_string($list);
        $class = new ClassApi();
        $list = $class->int_2_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '所有用户';
        $this->display();
    }

    public function add($name='', $password='',$repassword='', $uid='', $type='', $cid='', $date='', $status=''){
        if(IS_POST){
            /* 检测密码 */
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }

            /* 调用注册接口注册用户 */
            $User   =   new UserApi;
            $uid    =   $User->register($name, $password, $uid, $type, $cid, $date, $status);
            if(0 < $uid){ //注册成功
                $this->success('用户添加成功！',U('index'));
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
            $this->meta_title = '新增用户';
            $this->assign("_department",array_keys(C('DEPARTMENT')));
            $this->assign('_action',CONTROLLER_NAME.'/'.ACTION_NAME);
            $this->display();
        }
    }
    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '用户名长度必须在16个字符以内！'; break;
            case -2:  $error = '用户名被禁止注册！'; break;
            case -3:  $error = '学号或工号被占用！'; break;
            case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
            case -5:  $error = '邮箱格式不正确！'; break;
            case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
            case -7:  $error = '邮箱被禁止注册！'; break;
            case -8:  $error = '邮箱被占用！'; break;
            case -9:  $error = '手机格式不正确！'; break;
            case -10: $error = '手机被禁止注册！'; break;
            case -11: $error = '手机号被占用！'; break;
            case -12: $error = '时间超出了范围！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }

    public function teacher(){
        $list = $this->lists('User',['type'=>1]);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '教师管理';
        $this->display();
    }
    public function student(){
        $list = $this->lists('User',['type'=>2]);
        int_to_string($list);
        $class = new ClassApi();
        $list = $class->int_2_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '教师管理';
        $this->display();
    }
}