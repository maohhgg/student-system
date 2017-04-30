<?php
namespace Home\Controller;
use Think\Controller;

class FileController extends HomeController{

    public function upload($cctid = ''){
        if(!is_login()){
             $this->error("你还没有权限");
        } else {
            
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('doc', 'docx', 'pdf', 'txt','md','html');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传文件 
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功
            
                $info = $info['file_data'];

                $id = D('File')->insert(
                    $info['name'],
                    $info['size'], 
                    $info['savepath'].$info['savename'], 
                    session('user_auth')['id'], 
                    $cctid);
                if($id){
                    $this->ajaxReturn(['id'=>$id]);
                } else {
                    $file=__ROOT__.'/Uploads/'.$info['savepath'].$info['savename'];
                    unlink($file);
                    $this->error('数据保存失败，请重试！');
                }
            }
        }
    }
}