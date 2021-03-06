<?php
namespace Admin\Api;

use User\Api\Api;
use Admin\Model\AnswerModel;

class AnswerApi extends Api{

    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new AnswerModel();
    }

    public function int_to_string($array){
        if(!empty($array)){
            if(count($array) == count($array,1)){
                return $this->bind_data($array);
            } else {
                foreach($array as $key => $v){
                    $array[$key] = $this->bind_data($array[$key]);
                }
            }
        }
        return $array;
    }

    /**
     *  删除一个问题下的的所有答案和文件
     *  
     */
    public function delete($map){
        $api = D('File');
        $file = $this->model->where($map)->field(['id','afid'])->select();
        foreach ($file as $key => $value) {
            $this->model->delete($value['id']);
            $api->deleteAll($value['afid']);
        }
        return true;
    }

    public function bind_data($data){
        $user = new \User\Api\UserApi;
        $file = D('File');

        $user = $user->info($data['uid']);
        $file = $file->info($data['afid']);
        $question = D("Question")->info($data['qid'],false,['id','title','description']);

        $data['user'] = $user;
        $data['file'] = $file;
        $data['question'] = $question;

        return $data;
    }
}