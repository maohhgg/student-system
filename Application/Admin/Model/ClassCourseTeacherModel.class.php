<?php
namespace Admin\Model;
use Think\Model;

/**
 * 模型
 */
class ClassCourseTeacherModel extends Model{
    /**
	 * 数据表前缀
	 * @var string
	 */
	protected $tablePrefix = DB_PREFIX;

    /**
	 * 数据库连接
	 * @var string
	 */
    protected $connection = DB_CONFIG;

    
	/* 模型自动验证 */
	protected $_validate = array(
		array('class', '1,10', "班级数据不合法", self::EXISTS_VALIDATE, 'length'),  
		array('course', '1,10', "课程数据不合法", self::EXISTS_VALIDATE, 'length'), 
		array('teacher', '1,10', "教师信息不合法" , self::EXISTS_VALIDATE, 'length'),
		array('start', '8,10', "开设时间信息不合法" , self::EXISTS_VALIDATE, 'length'),
		array('end', '8,10', "开设时间信息不合法" , self::EXISTS_VALIDATE, 'length'),
		array('status', [0,1], "教师信息不合法" , self::EXISTS_VALIDATE, 'in'),
	);

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
        $data = [
			'class' => $class,
			'course' => $course,
			'teacher' => $teacher,
			'start' => $start,
			'end' => $end,
			'status' => $status,
		];
		/* 新增 */
		if($this->create($data)){
			$id = $this->add();
            
			return $id ? $id : 0; //0-未知错误，大于0-添加成功
		} else {
			return $this->getError(); //错误详情见自动验证注释
		}
    }
    /**
	 * 获取课程信息
	 * @param  string  $id         课程id
	 * @return string             课程信息 
	 */
	public function info($id){
		$map = ['id' => $id];
		$data= $this->where($map)->field('id,class,course,teacher,start,end,status')->find();
		if(is_array($data)){
			return $data;
		} else {
			return -1; //用户不存在或被禁用
		}
    }
}