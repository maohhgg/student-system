<?php
namespace Admin\Api;

use User\Api\Api;
use Admin\Model\ClassModel;

class ClassApi extends Api{

    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new ClassModel();
    }

    /**
     * 添加一个新班级
	 * @param  string $grade   那一届
	 * @param  string $name    专业名
	 * @param  string $no      班号
     * @param  string $date     开学时间
	 * @param  string $type     所属系
	 * @param  string $status    班级状态  0 已毕业  1正常
     * @return integer          添加成功-班级id，注册失败-错误编号
     */
	public function insert($grade, $name, $no, $date, $type, $status){
        return $this->model->insert($grade, $name, $no, $date, $type, $status);
    }
    /**
	 * 获取班级信息
	 * @param  string  $id         班级id
	 * @param  string  $merge      是否启用美化
	 * @return string             班级信息 2017届软件工程四班
	 */
	public function info($id,$merge = true){
       return $this->model->info($id,$merge);
    }

    /* 使Class信息更有可读性 */
    public function merge($map,$array = []){
        return $this->model->merge($map,$array);
    }

    /**
     * 更新班级信息
     * @param int $uid 班级id
     * @param array $data 修改的字段数组
     * @return true 修改成功，false 修改失败
     */
    public function updateInfo($uid, $data){
        if($this->model->updateClassFields($uid, $data) !== false){
            $return['status'] = true;
        }else{
            $return['status'] = false;
            $return['info'] = $this->model->getError();
        }
        return $return;
    }
    /**
     * 得到这个班级所有的课程
     *
     */
    public function getCourse($id = ''){
        if(empty($id)){
            return false;
        }
        $cct = new CCTApi;
        $list = $cct->info($id,true);
        if($list){
            $list = $cct->int_2_string($list);
            return $list;
        } else {
            return false;
        }
    }

    /**
     *  对包含学生的数组进行班级id对班级信息的转换
     * @param  Array $array       包含用户的数组 可一维数组 可二维数组
	 * @return Array       替换完成的数组       
     */
    public function int_2_string($array){
        if(count($array) == count($array,1)){
            if($this->is_student($array)){
               return $this->bind_class($array);
            }
        } else {
            foreach($array as $key => $v){
                if($this->is_student($v)){
                    $array[$key] = $this->bind_class($array[$key]);
                }
            }
        }
        return $array;
    }

    private function is_student($array){
        return $array['type'] == 2 ? true : false;
    }

    private function bind_class($data){
        if(is_numeric($data['cid'])){
            $class = $this->info($data['cid']);  
            $data['class'] = $class['text'];
            $data['tid'] = $class['type'];
        }
        return $data;
    }


}