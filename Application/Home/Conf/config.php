<?php
return array(
    'WEB_SITE_TITLE' => "学生作业管理系统",
     /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
    ),

    'NAV_MENU' => [
        ['title' => "首页",'target' => "",'url' => "Index/index",],
        ['title' => "首页",'target' => "1",'url' => "Index/index",],
        ['title' => "发布作业",'target' => "0",'auth'=>1,'url' => "Article/add",],
    ],
);