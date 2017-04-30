<?php
namespace Admin\Model;
use Think\Model;

class FileModel extends Model{

	public function insert($name, $size, $path, $uid, $cctid){
        $data = [
			'name' => $name,
			'size' => $size,
			'path' => $path,
			'uid' => $uid,
			'date' => date("Y-m-d H:i:s"),
			'cctcid' => $cctid,
		];

		/* 新增 */
		if($this->create($data)){
			$id = $this->add();
			return $id ? $id : 0; //0-未知错误，大于0-添加成功
		} else {
			return $this->getError(); //错误详情见自动验证注释
		}
    }

	public function info($id,$cctid = false){
        if($cctid){
            $map = ['cctid' => $id];
        } else {
            $map = ['id' => $id];
        }
		
		$class = $this->where($map)->find();
		if(is_array($class)){
			return $class;
		} else {
			return false; //用户不存在或被禁用
		}
    }

	public function deleteAll($id){
		$data = $this->info($id);
		$file=__ROOT__.'/Uploads/'.$data['path'];
        unlink($file);
		return $this->delete($id);
	}

	public function int_2_string($array){
		$user = new \User\Api\UserApi;
		if(is_array($array)){
			foreach($array as $key => $v){
				$array[$key]['user'] =  $user->info($v['uid'])['name'];
			}
		}
		return $array;
	}
}