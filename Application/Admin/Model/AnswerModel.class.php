<?php
namespace Admin\Model;
use Think\Model;
class AnswerModel extends Model{

    public function insert($afid, $uid, $qid){
        $data = [
			'afid' => $afid,
			'uid' => $uid,
			'qid' => $qid,
			'date' => date("Y-m-d H:i:s"),
			'score' => '-1',
		];

		/* 新增 */
		if($this->create($data)){
			$id = $this->add();
			return $id ? $id : 0; //0-未知错误，大于0-添加成功
		} else {
			return $this->getError(); //错误详情见自动验证注释
		}
    }

	public function info($id,$qid = false){
        if($qid){
            $map = ['qid' => $id];
			$answer = $this->where($map)->select();
			foreach($answer as $key => $v){
				$user = new \User\Api\UserApi;
				$file = D('File');

				$user = $user->info($v['uid']);
				$file = $file->info($v['afid']);
				$answer[$key]['name'] = $user['name'];
				$answer[$key]['uid'] = $user['uid'];
				$answer[$key]['file_name'] = $file['name'];
				$answer[$key]['file_path'] = $file['path'];
			}
        } else {
            $map = ['id' => $id];
			$answer = $this->where($map)->find();
        }
		
		if(is_array($answer)){
			return $answer;
		} else {
			return false; //用户不存在或被禁用
		}
    }
}