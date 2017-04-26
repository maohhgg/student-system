<?php

namespace User\Model;
use Think\Model;
/**
 * 用户模型
 */
class UserModel extends Model{
	/**
	 * 数据表前缀
	 * @var string
	 */
	protected $tablePrefix = DB_PREFIX;

    /**
	 * 数据库连接
	 * @var string
	 */
    protected $connection = DB_CONFIG;


	/* 用户模型自动验证 */
	protected $_validate = array(
		/* 验证用户名 */
		array('name', '1,30', -1, self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
		/* 验证登记时间 */
		array('date', "8,10", -12, self::EXISTS_VALIDATE, 'length'), 
		array('uid', '',-3,self::EXISTS_VALIDATE,'unique',1), 

		/* 验证密码 */
		array('password', '6,30', -4, self::EXISTS_VALIDATE, 'length'), //密码长度不合法
	);

	/* 用户模型自动完成 */
	protected $_auto = array(
		array('password', 'think_ucenter_md5', self::MODEL_BOTH, 'function', AUTH_KEY),
	);


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
		$data = array(
			'name' => $name,
			'password' => $password,
			'uid'    => $uid,
			'type'   => $type,
			'cid'   => $cid,
			'date'   => $date,
			'status'   => $status,
		);
        //验证学号
		if(empty($data['uid'])) unset($data['uid']);
        //验证班级id
		if(empty($data['cid'])) unset($data['cid']);

		/* 添加用户 */
		if($this->create($data)){
			$uid = $this->add();
			return $uid ? $uid : 0; //0-未知错误，大于0-注册成功
		} else {
			return $this->getError(); //错误详情见自动验证注释
		}
	}

	/**
	 * 用户登录认证
	 * @param  string  $name 用户名
	 * @param  string  $password 用户密码
	 * @param  integer $type     用户名类型 （1-用户名，2-学号，3-ID）
	 * @return integer           登录成功-用户ID，登录失败-错误编号
	 */
	public function login($name, $password, $type = 1){
		$map = array();
		switch ($type) {
			case 1:
				$map['name'] = $name;
				break;
			case 2:
				$map['uid'] = $name;
				break;
			case 3:
				$map['id'] = $name;
				break;
			default:
				return 0; //参数错误
		}

		/* 获取用户数据 */
		$user = $this->where($map)->find();
		if(is_array($user)){
			/* 验证用户密码 */
			if(think_ucenter_md5($password, AUTH_KEY) === $user['password']){
				return $user['id']; //登录成功，返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在
		}
	}

	/**
	 * 获取用户信息
	 * @param  string  $uid         用户ID或用户名
	 * @param  boolean $is_name 是否使用用户名查询
	 * @return array                用户信息
	 */
	public function info($id, $is_name = false){
		$map = array();
		if($is_name){ //通过用户名获取
			$map['name'] = $id;
		} else {
			$map['id'] = $id;
		}

		$user = $this->where($map)->field('id,name,uid,type,cid,date,status')->find();
		if(is_array($user)){
			return $user;
		} else {
			return -1; //用户不存在或被禁用
		}
	}


	/**
	 * 更新用户信息
	 * @param int $id 用户id
	 * @param string $password 密码，用来验证
	 * @param array $data 修改的字段数组
	 * @return true 修改成功，false 修改失败
	 * @author huajie <banhuajie@163.com>
	 */
	public function updateUserFields($id, $password, $data){
		if(empty($id) || empty($password) || empty($data)){
			$this->error = '参数错误！';
			return false;
		}

		//更新前检查用户密码
		if(!$this->verifyUser($id, $password)){
			$this->error = '验证出错：密码不正确！';
			return false;
		}

		//更新用户信息
		$data = $this->create($data);
		if($data){
			return $this->where(array('id'=>$id))->save($data);
		}
		return false;
	}

    
	/**
	 * 检测用户信息
	 * @param  string  $field  用户名
	 * @param  integer $type   用户名类型 1-用户名，2-学号
	 * @return integer         错误编号
	 */
	public function checkField($field, $type = 1){
		$data = array();
		switch ($type) {
			case 1:
				$data['name'] = $field;
				break;
			case 2:
				$data['uid'] = $field;
				break;
			default:
				return 0; //参数错误
		}

		return $this->create($data) ? 1 : $this->getError();
	}

	/**
	 * 验证用户密码
	 * @param int $id 用户id
	 * @param string $password_in 密码
	 * @return true 验证成功，false 验证失败
	 * @author huajie <banhuajie@163.com>
	 */
	protected function verifyUser($id, $password_in){
		$password = $this->getFieldById($id, 'password');
		if(think_ucenter_md5($password_in, AUTH_KEY) === $password){
			return true;
		}
		return false;
	}

}
