
<?php
use Yaf\Request_Abstract;
class IndexController extends Yaf\Controller_Abstract{
	public function IndexAction(){
		return true;
	}
	public function ShowAction(){
		if($this->getRequest()->isPost()){
			$gsf = array();
			$bsf = array();
			$post = $this->getRequest()->getPost();
			$result = array();
			$num = $post['haoren'];
			$lrnum = $post['langren'];
			foreach ($post['shenfen'] as $v){
				if($v==1 || $v==2 || $v==3 || $v==4 || $v==5){
					$gsf[]=$v;
				}
				if($v==6 || $v==7){
					$bsf[]=$v;
				}
				$result[][] = (int)$v;
			}
			$sfnum = count($post['shenfen']);
			$pnum = $num - $lrnum - $sfnum;
			for ($x=0; $x<$pnum; $x++) {
				$result[][]=10;
			}
			for ($x=0; $x<$lrnum; $x++) {
				$result[][]=11;
			}
			
			foreach($result as $k =>$v){
				if($v[0]==1){
					$result[$k][1]='预言家';
				}
				if($v[0]==2){
					$result[$k][1]="女巫";
				}
				if($v[0]==3){
					$result[$k][1]='猎人';
				}
				if($v[0]==4){
					$result[$k][1]='白痴';
				}
				if($v[0]==5){
					$result[$k][1]='守卫';
				}
				if($v[0]==6){
					$result[$k][1]='丘比特';
				}
				if($v[0]==7){
					$result[$k][1]='狼王';
				}
				if($v[0]==8){
					$result[$k][1]='盗贼';
				}
				if($v[0]==10){
					$result[$k][1]='村民';
				}

				if($v[0]==11){
					$result[$k][1]='狼人';
				}
			}
			$result_sf = array();
			$arr=range(0,$num-1);
			shuffle($arr);
			foreach($arr as $v)
			{
				$result_sf[] = $result[$v];
			}
			$this->getView()->assign('result', $result_sf);
			
			
		}
		return true;
	}
}