<?php

class TagController extends Yaf\Controller_Abstract{
	public function IndexAction(){
		$modle = new AdminModel();
		$tag = $modle->getInfo('tag');
		$this->getView()->assign('tag',$tag);
		return true;
	}
public function delAction(){
		$model = new AdminModel();
	 	$tid = $this->getRequest()->getParam('tid');
		$del = $model -> deleteInfo('art_tag', 'tag_tid='.$tid);
		$del = $model -> deleteInfo('tag','tid='.$tid);
		if($del){
			$this -> forward('admin','tag','index');
		}
		return false;
	}
public function addAction(){
		if($this->getRequest()->isPost()){
			$model = new AdminModel();			
			$array = $this->getRequest()->getPost();
			$char = implode("','", $array);
			$str = "('".$char."')";
			$add = $model->add('tag',$str,'tname');
			if($add){
				$this->forward('admin','tag','index');
			}
		}
		return false;
	}
}