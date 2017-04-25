<?php

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    /* 模块相关配置 */
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common', 'User'),
    //'MODULE_ALLOW_LIST'  => array('Home','Admin'),

	/* 模板文件的默认后缀 */
	'TMPL_TEMPLATE_SUFFIX'=>'.view',

    /* 调试配置 */
    'SHOW_PAGE_TRACE' => true,


    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 3, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数

    /* 数据库配置 */
    'DB_TYPE'   => 'mysqli', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'system', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'sys_', // 数据库表前缀
    'DB_CONFIG' => 'mysqli://root:root@127.0.0.1:3306/system',
);
