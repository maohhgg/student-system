<?php
namespace Admin\Controller;
use \Admin\Api\AnswerApi;
use \Admin\Api\QuestionApi;

class ArticleController extends AdminController{

    public function index($id=''){
        $api = new QuestionApi;
        $list = $this->lists('Question');
        $list = $api->int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = "内容管理";
        $this->display();
    }

    public function file(){
        $list = $this->lists('File');
        $list = D('File')->int_2_string($list);
        $this->assign('_list', $list);
        $this->meta_title = "全部文件";
        $this->display();
    }

    public function socre(){
        $list = $this->lists('Answer');
        $api = new AnswerApi;
        $list = $api->int_to_string($list);
        $this->meta_title = "全部成绩";
        $this->assign('_list', $list);
        $this->display();
    }

    public function filedelete($id){
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        if($api->delete($id)&&D('Question')->delete($id)){
            $this->success('删除成功！',U('index'));
        } else{
             $this->error('删除失败请重试！');
        }
    }

    public function changeStatus($method=null, $id='', $title='', $description='', $content='', $qfid='', $afid='', $cctid='',$answer=''){
        if(!IS_POST && !empty($method)){
            $id = I('id');
            if ( empty($id) ) {
                $this->error('请选择要操作的数据!');
            }
            $api = new AnswerApi;
            switch ( strtolower($method) ){
                case 'delete':
                    if($api->delete(['qid'=>$id])&&D('Question')->delete($id)){
                        $this->success('删除成功！',U('index'));
                    } else {
                        $this->error('删除失败请重试！');
                    }
                    break;
                default:
                    $this->error('参数非法');
            }
        } else if(IS_POST && $id) {
             $class   =   new QuestionApi;
             $data = [
                'title' => $title,
                'description' => $description,
                'content' => $content,
                'qfid' => $qfid,
                'afid' => $afid,
                'cctid' => $cctid,
                'answer' => $answer,
            ];
            foreach($data as $key => $v){
                if (empty($v)) {
                    unset($data[$key]); //删除空的属性
                }
            }
            $info = $api->updateInfo($id, $data);
            if(is_numeric($info)){
               $this->success('修改成功！',U('index'));
            } else {
                $this->error($info);
            }
        }
    }
}