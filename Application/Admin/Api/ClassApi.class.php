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
     * @return integer          添加成功-班级id，注册失败-错误编号
     */
	public function insert($grade, $name, $no, $date, $type){
        return $this->model->insert($grade, $name, $no, $date, $type);
    }
    /**
	 * 获取班级信息
	 * @param  string  $id         班级id
	 * @return string             班级信息 2017届软件工程四班
	 */
	public function info($id){
       return $this->model->info($id);
    }
}