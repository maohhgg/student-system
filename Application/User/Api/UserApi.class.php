<?php

namespace User\Api;
use User\Api\Api;
use User\Model\UserModel;

class UserApi extends Api{
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new UserModel();
    }

    /**
     * 注册一个新用户
	 * @param  string $name 用户名
	 * @param  string $password 用户密码
	 * @param  string $uid      学号
	 * @param  string $type     用户类型
	 * @param  string $cid      班级id
     * @param  string $date     入职时间
	 * @param  string $status    状态- 在职 离职 休假 在读 毕业
     * @return integer          注册成功-用户信息，注册失败-错误编号
     */
    public function register($name, $password, $uid, $type, $cid, $date, $status){
        return $this->model->register($name, $password, $uid, $type, $cid, $date, $status);
    }

    /**
     * 用户登录认证
     * @param  string  $name 用户名
     * @param  string  $password 用户密码
     * @param  integer $type     用户名类型 （1-用户名，2-学号，3-ID）
     * @return integer           登录成功-用户ID，登录失败-错误编号
     */
    public function login($name, $password, $type = 1){
        return $this->model->login($name, $password, $type);
    }

    /**
     * 获取用户信息
     * @param  string  $uid         用户ID或用户名
     * @param  boolean $is_name 是否使用用户名查询
     * @return array                用户信息
     */
    public function info($id, $is_name = false){
        return $this->model->info($id, $is_name);
    }

    /**
     * 检测用户名
     * @param  string  $field  用户名
     * @return integer         错误编号
     */
    public function checkname($name){
        return $this->model->checkField($name, 1);
    }


    /**
     * 更新用户信息
     * @param int $uid 用户id
     * @param array $data 修改的字段数组
     * @return true 修改成功，false 修改失败
     */
    public function updateInfo($uid, $data){
        if($this->model->updateUserFields($uid, $data) !== false){
            $return['status'] = true;
        }else{
            $return['status'] = false;
            $return['info'] = $this->model->getError();
        }
        return $return;
    }
    /**
     * 得到这个学生班级所有的课程
     *
     */
    public function getCourse($id = ''){
        if(empty($id)){
            return false;
        }
        $class = new \Admin\Api\ClassApi;
        $user = $this->info($id);
        return $class->getCourse($user['cid']);
    }

    /**
     * 得到用
     *
     */
    public function getQuestion($id = '', $cctid = ''){
        if(empty($id)){
            return 0;
        }
        $class = new \Admin\Api\ClassApi;
        if(empty($cctid)) {

        }
    }

}
