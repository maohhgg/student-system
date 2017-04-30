<?php
namespace Admin\Api;

use Home\Model\QuestionModel;
use Home\Model\FileModel;
use Admin\Api\CCTApi;

class QuestionApi extends \User\Api\Api{

    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new QuestionModel();
        $this->cct = new CCTApi();
        $this->file = new FileModel();
    }

 /**
     * 添加一个新课程
	 * @param  string $title    标题
	 * @param  string $content    内容
	 * @param  string $qfid  问题文件
	 * @param  string $afid    答案文件
	 * @param  string $cctid   
	 * @param  string $date    日期
	 * @param  string $answer    答案是否启用
     */
	public function insert($title, $description, $content, $qfid, $afid, $cctid, $answer){
        return $this->model->insert($title, $description, $content, $qfid, $afid, $cctid, $answer);
    }
     /**
	 * 获取附件信息
	 * @param  string  $id        问题id
	 * @return string             课程信息 
	 */
	public function file($data){
        if($data){
            $file = new \Home\Model\FileModel();
            $files['answer'] = $file->where(['id'=>$data['afid']])->find();
            $files['question'] = $file->where(['id'=>$data['qfid']])->find();
            return $files;
        } else {
            return false;
        }
    }


    /**
	 * 获取课程信息
	 * @param  string  $id         id
	 * @param  string  $id        cctid
	 * @return string             课程信息 
	 */
	public function detail($id,$cctid=false){
        $data = $this->model->info($id,$cctid);
        if($data){
            return $this->int_to_string($data);
        } else {
            return false;
        }
    }
    public function lists($cctid='', $order = '`id` DESC', $field = true){
        return $this->model->lists($cctid, $order, $field);
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


    private function bind_data($data){
        if(is_numeric($data['afid'])){
            $data['anwser_file'] = $this->file->info($data['afid']);
        } 

        if(is_numeric($data['qfid'])){
            $data['question_file'] = $this->file->info($data['qfid']);
        }

        if(is_numeric($data['cctid'])){
            $array = $this->cct->info($data['cctid']);
            $array = $this->cct->int_2_string($array);
        }
        unset($array['id']);
        return array_merge($data,$array);
    }

}