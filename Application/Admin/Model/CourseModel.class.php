<?php
namespace Admin\Model;
use Think\Model;

/**
 * 课程模型
 */
class CourseModel extends Model{
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
		array('name', '1,40', "名称不合法", self::EXISTS_VALIDATE, 'length'),  // 专业名不合法
	);
    /**
     * 添加一个新课程
	 * @param  string $name    课程名
	 * @param  string $no      描述
     */
	public function insert($name, $tag){
        $data = [
			'name' => $name,
			'tag' => $tag,
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
		$data= $this->where($map)->field('id,name,tag')->find();
		if(is_array($data)){
			return $data;
		} else {
			return -1; //用户不存在或被禁用
		}
    }
}