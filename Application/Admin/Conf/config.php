<?php
return array(
     /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
    ),
    /* 导航菜单 */
    'TEMP_MENU' =>  array(
        ['title'=>'首页','url'=>'Index/index'],
        [
            'title' =>'用户',
            'url'   =>'User/index',
            'child' =>[
                '用户管理' => [
                    ['title'=>'所有用户','url'=>'User/index'],
                    ['title'=>'学生管理','url'=>'User/student'],
                    ['title'=>'教师管理','url'=>'User/teacher'],
                ],
                '操作用户' => [
                     ['title'=>'新增用户','url'=>'User/add'],
                ]
            ],
        ],   
        [
            'title'=>'内容',
            'url'=>'Article/index',
            'child' =>[
                '用户管理' => [
                    ['title'=>'学生管理','url'=>'User/index'],
                    ['title'=>'教师管理','url'=>'User/teacher'],
                ]
            ],
        ],
        [
            'title'=>'班级',
            'url'=>'Class/index',
            'child' =>[
                '班级管理' => [
                    ['title'=>'所有班级','url'=>'Class/index'],
                ]
            ],
        ],
    ),

    /*  分页 每页显示数量 */
    'LIST_ROWS' => 15,
);