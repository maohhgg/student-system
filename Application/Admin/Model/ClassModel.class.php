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


	/* 模型自动验证 */
	protected $_validate = array(
		array('type', [0,1,2,3], -1, self::EXISTS_VALIDATE, 'in'), // 所属系部不存在
		array('name', '1,20', -2, self::EXISTS_VALIDATE, 'length'),  // 专业名不合法
		array('date', '8,10', -3, self::EXISTS_VALIDATE, 'length'),  // 时间数据不合法
		array('grade', '4,4', -4, self::EXISTS_VALIDATE, 'length'),  // 年级数据不合法
		array('no', '1,4', -5, self::EXISTS_VALIDATE, 'length'),  // 班号数据不合法
		array('status', [0,1], -6, self::EXISTS_VALIDATE, 'in'),  // 班级状态数据不合法

	);


	
    /**
     * 添加一个新班级
	 * @param  string $grade   那一届
	 * @param  string $name    专业名
	 * @param  string $no      班号
     * @param  string $date     开学时间
	 * @param  string $type     所属系
	 * @param  string $status    班级状态  0 已毕业  1正常
     * @return integer          添加成功-班级id，添加失败-错误编号
     */
	public function insert($grade, $name, $no, $date, $type, $status){
        $data = [
			'grade' => $grade,
			'name' => $name,
			'no' => $no,
			'date' => $date,
			'type' => $type,
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
	 * 获取班级信息
	 * @param  string  $id         班级id
	 * @param  string  $merge      是否启用美化
	 * @return string             班级信息 2017届软件工程四班
	 */
	public function info($id,$merge = true){
		$map = ['id' => $id];
		$class = $this->where($map)->field('id,grade,name,no,date,type,status')->find();
		if(is_array($class)){
			if($merge){
				return $this->merge($class);
			} else {
				return $class;
			};
		} else {
			return -1; //用户不存在或被禁用
		}
    }

	/**
	 * 更新班级信息
	 * @param int $id 班级id
	 * @param array $data 修改的字段数组
	 * @return true 修改成功，false 修改失败
	 */
	public function updateClassFields($id, $data){
		if(empty($id) || empty($data)){
			$this->error = '参数错误！';
			return false;
		}
		$data = $this->create($data,Model::MODEL_UPDATE);
		if($data){
			return $this->where(array('id'=>$id))->save($data);
		}
		return false;
	}

	/* 使Class信息更有可读性 */
	public function merge($map,$array = []){
		if(count($map) == count($map, 1)){
			$this->replace($map);
			if(!empty($array)){
				$map['type'] = $array[$map['type']];
			}
		} else if(empty($array)){
			foreach($map as $key => $v){
				$this->replace($map[$key]);
			}
		} else {
			foreach($map as $key => $v){
				$this->replace($map[$key]);
				$map[$key]['type'] = $array[$v['type']];
			}
		}
		return $map;
	}
	public function replace(&$map){
		$map['text'] = "{$map['name']}专业 {$map['grade']}级{$this->cenvt($map['no'])}班";
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