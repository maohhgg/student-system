<?php
namespace Admin\Model;
use Think\Model;

/**
 * 班级模型
 */
class ClassModel extends Model{
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


	/* 用户模型自动验证 */
	protected $_validate = array(
		array('type', [0,1,2,3], -1, self::EXISTS_VALIDATE, 'in'), // 所属系部不存在
		array('name', '1,20', -2, self::EXISTS_VALIDATE, 'length'),  // 专业名不合法
		array('date', '8,10', -3, self::EXISTS_VALIDATE, 'length'),  // 时间数据不合法
		array('grade', '4,4', -4, self::EXISTS_VALIDATE, 'length'),  // 年级数据不合法
		array('no', '1,4', -5, self::EXISTS_VALIDATE, 'length'),  // 班号数据不合法

	);


	
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
        $data = [
			'grade' => $grade,
			'name' => $name,
			'no' => $no,
			'date' => $date,
			'type' => $type,
		];

		/* 新增 */
		if($this->create($data)){
			$id = $this->add();
			return $id ? $id : 0; //0-未知错误，大于0-注册成功
		} else {
			return $this->getError(); //错误详情见自动验证注释
		}
    }

	 /**
	 * 获取班级信息
	 * @param  string  $id         班级id
	 * @return string             班级信息 2017届软件工程四班
	 */
	public function info($id){
		$map = ['id' => $id];
		$class = $this->where($map)->field('id,grade,name,no,date,type')->find();
		if(is_array($class)){
			return $this->merge($class);
		} else {
			return -1; //用户不存在或被禁用
		}
    }

	/* 使Class信息更有可读性 */
	public function merge($map,$array = []){
		print_r($array);
		if(count($map) == count($map, 1)){
			$map['text'] = "{$map['grade']}届{$map['name']}{$this->cenvt($map['no'])}班";
			if(!empty($array)){
				$map['type'] = $array[$map['type']];
			}
		} else if(empty($array)){
			foreach($map as $key => $v){
				$map[$key]['text'] = "{$v['grade']}届{$v['name']}{$this->cenvt($v['no'])}班";
			}
		} else {
			foreach($map as $key => $v){
				$map[$key]['text'] = "{$v['grade']}届{$v['name']}{$this->cenvt($v['no'])}班";
				$map[$key]['type'] = $array[$v['type']];
			}
		}
		return $map;
	}

	/* 将数字转化为汉字 */
	private function cenvt($num,$map=['零','一','二','三','四','五','六','七','八','九',]){
		if($num === 10){
			return '十';
		}
		$string = "";
		$array = str_split((string)$num);
		foreach($array as $v){
			$string .= $map[$v];
		}
		return $string;
	}
}