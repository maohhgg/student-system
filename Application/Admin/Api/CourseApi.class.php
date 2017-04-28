<?php
namespace Admin\Api;

use User\Api\Api;
use Admin\Model\CourseModel;

class CourseApi extends Api{

    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new CourseModel();
    }

    /**
     * 添加一个新课程
	 * @param  string $name    课程名
	 * @param  string $no      描述
     */
	public function insert($name, $tag){
        return $this->model->insert($name, $tag);
    }

    /**
	 * 获取课程信息
	 * @param  string  $id         课程id
	 * @return string             课程信息 
	 */
	public function info($id){
        return $this->model->info($id);
    }
}