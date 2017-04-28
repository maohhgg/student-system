<?php
namespace Home\Controller;
use Think\Controller;

class HomeController extends Controller{

    protected function _initialize(){
        $nav = C("NAV_MENU");
        if(!$this->auth()){
            $this->navAuth($nav);
        } 
        $this->assign('nav',$nav);
    }

	/* 用户登录检测 */
	protected function login(){
		/* 用户登录检测 */
		is_login() || $this->error('您还没有登录，请先登录！', U('User/login'));
	}

    protected function auth(){
        if(is_login() && session('user_auth')['type'] < 2){
            return true;
        } else {
            return false;
        }
    }

    protected function navAuth(&$nav){
        foreach ($nav as $key => $value) {
            if(isset($value['auth']) && $value['auth'] === 1){
                unset($nav[$key]);
            }
        }
    }
    
}