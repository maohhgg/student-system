<?php
namespace Home\Api;

use Home\Model\QuestionModel;
use Admin\Api\CCTApi;

class QuestionApi extends \User\Api\Api{

    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new QuestionModel();
        $this->cct = new CCTApi();
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
	public function insert($title, $content, $qfid, $afid, $cctid, $date, $answer){
        return $this->model->insert($title, $content, $qfid, $afid, $cctid, $date, $answer);
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

    public function int_to_string($array){
        if(count($array) == count($array,1)){
            return $this->bind_data($array);
        } else {
            foreach($array as $key => $v){
                $array[$key] = $this->bind_data($array[$key]);
            }
        }
        return $array;
    }


    private function bind_data($data){
        if(is_numeric($data['cctid'])){
            $array = $this->cct->info($data['cctid']);
            $array = $this->cct->int_2_string($array);
        }
        return array_merge($data,$array);
    }

}