<?php
/**
 * select返回的数组进行整数映射转换
 *
 * @param array $map  映射关系二维数组  array(
 *                                          '字段名1'=>array(映射关系数组),
 *                                          '字段名2'=>array(映射关系数组),
 *                                           ......
 *                                       )
 * @return array
 *
 *  array(
 *      array('id'=>1,'name'=>'admin','type'=>'管理员')
 *      ....
 *  )
 *
 */
function int_to_string(&$data,$type=array('type'=>array(0=>'管理员',1=>'教师',2=>'学生')),$status=array('status'=>array(-1=>'毕业',0=>'离职',1=>'在职',2=>'在读',3=>'请假中'))) {
    if($data === false || $data === null ){
        return $data;
    }
    $data = (array)$data;
    foreach ($data as $key => $row){
        foreach ($type as $tcol=>$tpair){
            if(isset($row[$tcol]) && isset($tpair[$row[$tcol]])){
                $data[$key][$tcol.'_text'] = $tpair[$row[$tcol]];
            }
        }
         foreach ($status as $scol=>$spair){
            if(isset($row[$scol]) && isset($spair[$row[$scol]])){
                $data[$key][$scol.'_text'] = $spair[$row[$scol]];
            }
        }
    }
    return $data;
}