<?php

namespace Admin\Controller;
use User\Api\UserApi;
use User\Model\UserModel;

/**
 * 后台首页控制器
 */
class PublicController extends \Think\Controller {

    /**
     * 后台用户登录
     */
    public function login($name = null, $password = null){
        if(IS_POST){
            /* 调用登录接口登录 */
            $User = new UserApi;
            if(count_chars($name) == 12){
                $uid = $User->login($name, $password,2);
            } else {
                $uid = $User->login($name, $password);
            }
            if(0 < $uid){ //UC登录成功
                /* 登录用户 */
                $model = new UserModel;
                $user = $model->info($uid);
                $auth = array(
                    'id'       => $user['id'],
                    'name'     => $user['name'],
                );

                session('user_auth', $auth);
                session('user_auth_sign', data_auth_sign($auth));
                $this->success('登录成功！', U('Index/index'));
            } else { //登录失败
                switch($uid) {
                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                    case -2: $error = '密码错误！'; break;
                    default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }
        } else {
            if(is_login()){
                $this->redirect('Index/index');
            }else{
                $this->display();
            }
        }
    }

    /* 退出登录 */
    public function logout(){
        if(is_login()){
            session('user_auth', null);
            session('user_auth_sign', null);
            session('[destroy]');
            $this->success('退出成功！', U('login'));
        } else {
            $this->redirect('login');
        }
    }

    public function verify(){
        $verify = new \Think\Verify();
        $verify->entry(1);
    }

}
