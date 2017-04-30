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
    public function lists($model,$where=array(),$order=null){
        $options = [];
        if(is_string($model)){
            $model  =   M($model);
        }

        if(!empty($order)){
            $options['order'] = $order;
        }else{
            $options['order'] = "id desc";
        }
        $options['where'] = array_filter($where, function($val){
            if($val===''||$val===null){
                return false;
            }else{
                return true;
            }
        });

        if( empty($options['where'])){
            unset($options['where']);
        }
        $total  =  $model->where($options['where'])->count();

        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        }

        $page = new \Think\Page($total, $listRows);
        if($total>$listRows){
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        }
        $p->lastSuffix = false;
        $p = $this->bootstrap_page_style($page->show());
        $this->assign('page', $p ? $p: '');
        $options['limit'] = $page->firstRow.','.$page->listRows;

        $model->setProperty('options',$options);

        return $model->select();
    }

    public function bootstrap_page_style($page_html){
        if ($page_html) {
            $page_show = str_replace('<div>','<nav><ul class="pagination">',$page_html);
            $page_show = str_replace('</div>','</ul></nav>',$page_show);
            $page_show = str_replace('<span class="current">','<li class="active"><a>',$page_show);
            $page_show = str_replace('</span>','</a></li>',$page_show);
            $page_show = str_replace(array('<a class="num"','<a class="prev"','<a class="next"','<a class="end"','<a class="first"'),'<li><a',$page_show);
            $page_show = str_replace('</a>','</a></li>',$page_show);
        }
        return $page_show;
    }
    
}