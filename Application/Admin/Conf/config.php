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
        [
            'title'=>'首页',
            'url'=>'Index/index',
            'child' =>[
                '首页' => [
                     ['title'=>'首页','url'=>'Index/index'],
                ]
            ],
        ],
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
                     ['title'=>'用户管理','url'=>'User/add'],
                ]
            ],
        ],   
        [
            'title'=>'内容',
            'url'=>'Article/index',
            'child' =>[
                '作业管理' => [
                    ['title'=>'所有作业','url'=>'Article/index'],
                ],
                '文件管理' => [
                    ['title'=>'所有文件','url'=>'Article/file'],
                ],
                '成绩管理' => [
                    ['title'=>'成绩信息','url'=>'Article/socre'],
                ],
            ],
        ],
        [
            'title'=>'班级',
            'url'=>'Class/index',
            'child' =>[
                '班级信息' => [
                    ['title'=>'所有班级','url'=>'Class/index'],
                    ['title'=>'班级课程','url'=>'Class/have'],
                ],
                '操作班级' => [
                     ['title'=>'班级管理','url'=>'Class/add'],
                ],
                '课程管理' => [
                     ['title'=>'所有课程','url'=>'Class/course/'],
                     ['title'=>'课程管理','url'=>'Class/course/?method=add'],
                ]
            ],
        ],
    ),

    /*  分页 每页显示数量 */
    'LIST_ROWS' => 15,

    /* 学校系别 */
    'DEPARTMENT' => [
        "计算机科学与技术系" => [
            '数据科学与大数据技术',
            '信息工程',
            '软件工程',
            '计算机科学与技术',
            '网络工程',
            '物联网工程' ,
            '软件技术',
            '信息安全与管理',
            '计算机网络技术',
        ],
        "信息技术与商务管理系" => [
            '人力资源管理',
            '财务管理',
            '资产评估',
            '物流管理',
            '电子商务',
            '信息管理与信息系统',
            '市场营销',
        ],
        "数字艺术系" => [
            '工业设计',
            '数字媒体技术',
            '动画',
            '产品艺术设计',
            '影视动画' ,  
        ],
        "应用外语系" => [
            '日语',
            '英语',
            '商务英语',
        ],
    ],

);