<?php
class IndexModel{
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
	private function Mysql(){
		$mysqli = @new mysqli("127.0.0.1","root","123456","boke");
		if($mysqli->connect_errno){
			echo $mysqli->connect_errno;exit;
		}
		return $mysqli;
	}
}