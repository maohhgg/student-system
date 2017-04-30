<?php
return array(
    'WEB_SITE_TITLE' => "学生作业管理系统",
     /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
        '__UPLOAD__'     => __ROOT__ . '/Uploads/',
    ),

    'NAV_MENU' => [
        ['title' => "首页",'target' => "0",'url' => "Index/index",],
        ['title' => "发布作业",'target' => "0",'auth'=>1,'url' => "Article/add",],
        ['title' => "作业评分",'target' => "0",'auth'=>1,'url' => "Answer/index",],
    ],
    /*  分页 每页显示数量 */
    'LIST_ROWS' => 6,
);