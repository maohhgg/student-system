<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\AuthRuleModel;
use Admin\Model\AuthGroupModel;

/**
 * 
 */
class AdminController extends Controller {
    
    /**
     * 后台控制器初始化
     */
    protected function _initialize(){
        // 获取当前用户ID
        define('UID',is_login());
        if( !UID ){// 还没登录 跳转到登录页面
            $this->redirect('Public/login');
        }
        $this->assign('__MENU__', $this->getMenus());
    }

    /**
     * 获取控制器菜单数组
     */
    final public function getMenus($controller=CONTROLLER_NAME){
        $config = C('TEMP_MENU');
        $menus = [];
        foreach ($config as $key => $value) {
            if(empty($config[$key]['class'])) unset($config[$key]['class']);

            if(strpos($value['url'], $controller) === 0){
                $config[$key]['class'] = 'current';
                if($value['child']){
                    $menus['child'] = $value['child'];
                }
            }
           
            unset($config[$key]['child']);
        }
        $menus['main'] = $config;
        return $menus;
    }

    /**
     * 通用分页列表数据集获取方法
     *
     *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
     *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
     *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
     *
     * @param sting|Model  $model   模型名或模型实例
     * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
     * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
     *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
     *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
     
     *
     * @return array|false
     * 返回数据集
     */
    protected function lists($model,$where=array(),$order=''){
        $options    =   array();
        $REQUEST    =   (array)I('request.');
        if(is_string($model)){
            $model  =   M($model);
        }

        $OPT        =   new \ReflectionProperty($model,'options');
        $OPT->setAccessible(true);
        if($order===null){
            //order置空
        }else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
            $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
        }elseif($order){
            $options['order'] = $order;
        }
        unset($REQUEST['_order'],$REQUEST['_field']);

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
        $options      =   array_merge( (array)$OPT->getValue($model), $options );
        $total        =   $model->where($options['where'])->fetchSql(true)->count();

        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        }
        $page = new \Think\Page($total, $listRows);
        if($total>$listRows){
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }
        $p->lastSuffix = false;
        $p =$page->show();
        $this->assign('_page', $p? $p: '');
        $this->assign('_total',$total);
        $options['limit'] = $page->firstRow.','.$page->listRows;

        $model->setProperty('options',$options);

        return $model->select();

    }
}
