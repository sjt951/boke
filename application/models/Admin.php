<?php
class AdminModel{
	public function getInfo($name,$where = '',$order='',$limit = ''){
		$mysqli = $this->Mysql();
		if($where){
			$sql = "SELECT * FROM " . $name . " WHERE " . $where;
		}else{
			$sql = "SELECT * FROM " . $name;
		}
		if($order){
			$sql = $sql . " ORDER BY ".$order;
		}
		if($limit){
			$sql = $sql . " limit " . $limit;
		}
		$result = $mysqli->query("SET NAMES UTF8");
		$result = $mysqli->query($sql);
// 		var_dump($result);echo $sql;echo "<br>";
		$rows = array();
		//fetch_assoc获得关联的数组结果
		while($row = $result->fetch_assoc()){
			$rows[] = $row;
		}
		//释放结果集
		$result->free();
		//关闭mysqli的连接
		$mysqli->close();
		return $rows;
	}
	
	
	
	public function add($name,$str,$var=''){
		$mysqli = $this->Mysql();
		if($var){
			$sql = 'INSERT INTO '.$name.' ('.$var.') VALUES '.$str;
		}else {
			$sql = 'INSERT INTO '.$name.' VALUES '.$str;			
		}
// 		var_dump($result);echo $sql;echo "<br>";
		$result = $mysqli->query("SET NAMES UTF8");
		$result = $mysqli->query($sql);
		if($name == 'article'){
			$aid = $mysqli->query('select max(aid) from '.$name);
			$rows = array();
			//fetch_assoc获得关联的数组结果
			while($row = $aid->fetch_assoc()){
				$rows[] = $row;
			}
			return $rows[0]['max(aid)'];
		}		
		
		//关闭mysqli的连接
		$mysqli->close();
		return $result;
	}
	
	
	
	
	public function deleteInfo($name,$where){
		$mysqli = $this->Mysql();
		if($where){
			$sql = "DELETE FROM " . $name . " WHERE " . $where;
		}
		$result = $mysqli->query($sql);
		//关闭mysqli的连接
		$mysqli->close();
		return TRUE;
	}
	public function getTag($arr){
		$tname = '';
		foreach ($arr as $key => $v){
			$tid = $this -> getInfo('art_tag','article_aid='.$v['aid']);
			foreach ($tid as $tag){
				$tag = $this -> getInfo('tag','tid='.$tag['tag_tid']);
				foreach ($tag as $tn){
					$tname = $tname.$tn['tname'].';';
				}
			}
			$arr[$key]['tag'] = $tname;
			$tname = '';
		}
		return $arr;
	}
	public function getCategory($arr){
		$cname = '';
		foreach ($arr as $key => $v){
			$cid = $this -> getInfo('art_cate','article_aid='.$v['aid']);
			foreach ($cid as $cn){
				$category = $this -> getInfo('category','cid='.$cn['category_cid']);
				foreach ($category as $tn){
					$cname = $cname.$tn['cname'].';';
				}
			}
			$arr[$key]['category'] = $cname;
			$cname = '';
		}
		return $arr;
	}
	private function Mysql(){
		$mysqli = @new mysqli("127.0.0.1","root","123456","boke");
		if($mysqli->connect_errno){
			echo $mysqli->connect_errno;exit;
		}
		return $mysqli;
	}
}