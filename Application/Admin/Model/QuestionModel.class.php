<?php
namespace Admin\Model;
use Think\Model;

/**
 * 模型
 */
class QuestionModel extends Model{


    
	/* 模型自动验证 */
	protected $_validate = array(
		array('title', '1,64', "标题数据不合法", self::EXISTS_VALIDATE, 'length'),  
		array('teacher', '1,10', "教师信息不合法" , self::EXISTS_VALIDATE, 'length'),
		array('date',"2000-1-1 0:0:0,{date(Y-m-d H:i:s)}" , "日期信息不合法" , self::EXISTS_VALIDATE, 'expire'),
	);

    /**
     * 添加一个新课程
	 * @param  string $title    标题
	 * @param  string $content    内容
	 * @param  string $qfid  问题文件
	 * @param  string $afid    答案文件
	 * @param  string $cctid   
	 * @param  string $date    日期
     */
	public function insert($title, $description, $content, $qfid, $afid, $cctid, $date){
        $data = [
			'title' => $title,
			'description' => $description,
			'content' => $content,
			'qfid' => $qfid,
			'afid' => $afid,
			'cctid' => $cctid,
			'date' => $date,
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
	 * @param  string  $id         id
	 * @param  string  $id        cctid
	 * @return string             课程信息 
	 */
	public function info($id, $cctid=false){
		if($cctid){
			$map = ['cctid' => $id];
			$data= $this->where($map)->find();
		} else {
			$map = ['id' => $id];
			$data= $this->where($map)->find();
		}
		if(is_array($data)){
			return $data;
		} else {
			return false; //不存在或被禁用
		}
    }

	 /**
	 * 获取列表
	 * @param  integer  $cctid  分类ID
	 * @param  string   $order    排序规则
	 * @param  boolean  $count    是否返回总数
	 * @param  string   $field    字段 true-所有字段
	 * @return array              文档列表
	 */
	public function lists($cctid, $order = '`id` DESC', $field = true){
		if(is_array($cctid)){
			foreach($cctid as $v){
				$arr[] = $v['id'];
			}
			$map['cctid'] = array('in',$arr);
		} else if( is_numeric($cctid)) {
			$map['cctid'] = $cctid;
		} else {
			$map['cctid'] = array('gt',0);
		}
		$data = $this->where($map)->field($field)->order($order)->select();
		if(is_array($data)){
			return $data;
		} else {
			return -1; //不存在或被禁用
		}
	}
}