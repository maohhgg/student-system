<?php
namespace Admin\Model;
use Think\Model;

/**
 * 班级模型
 */
class ClassModel extends Model{
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
		array('date', "1970-1-1 0:0:0,{date('Y-m-d H:i:s')}", -12, self::EXISTS_VALIDATE, 'expire'), //用户名长度不合法

		/* 验证密码 */
		array('password', '6,30', -4, self::EXISTS_VALIDATE, 'length'), //密码长度不合法
	);

	/* 用户模型自动完成 */
	protected $_auto = array(
		array('password', 'think_ucenter_md5', self::MODEL_BOTH, 'function', AUTH_KEY),
	);
}