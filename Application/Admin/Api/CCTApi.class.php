<?php
namespace Admin\Api;

use User\Api\Api;
use Admin\Model\ClassCourseTeacherModel;

class CCTApi extends Api{

    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        $this->model = new ClassCourseTeacherModel();
    }

    /**
     * 添加一个新课程
	 * @param  string $class    班级id
	 * @param  string $course    课程id
	 * @param  string $teacher  教师id
	 * @param  string $start    开始时间
	 * @param  string $end   结束时间
	 * @param  string $status     状态 0 结业 1 正常上课
     */
	public function insert($class, $course, $teacher, $start, $end, $status){
        return $this->model->insert($class, $course, $teacher, $start, $end, $status);
    }

    /**
	 * 获取课程信息
	 * @param  string  $id         课程id
	 * @param  string  $class       id是否为班级id
	 * @return array             课程信息 
	 */
	public function info($id,$class=false){
        return $this->model->info($id,$class);
    }
    /**
	 * 获取课程信息
	 * @param  array  $map         课程id
	 * @return array             课程信息 
	 */
	public function lists($map=array()){
        return $this->int_2_string($this->model->lists($map));
    }

     /**
     *  对数组进行id对具体信息的转换
     * @param  Array $array       包含ClassCourseTeacherModel的数组 可一维数组 可二维数组
	 * @return Array       替换完成的数组       
     */
    public function int_2_string($array){
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
         if($data['class'] && $data['course'] && $data['teacher'] ){
             $user = new \User\Api\UserApi;
             $course = new CourseApi;
             $class = new ClassApi; 
             $data['class'] = $class->info($data['class'])['text'];
             $data['course'] = $course->info($data['course'])['name'];
             $data['teacher'] = $user->info($data['teacher'])['name'];
             $data['expiry'] =  $data['start']." 到 ". $data['start'];
         }
         return $data;
     }
    

}