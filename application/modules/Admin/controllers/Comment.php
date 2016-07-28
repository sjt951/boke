<?php

class CommentController extends Yaf\Controller_Abstract{
	public function IndexAction(){
		$model = new AdminModel();
		$com = $model -> getInfo('comment');
		$this->getView()->assign('com', $com);
		return true;
	}
	public function delAction(){
		$model = new AdminModel();
		$coid = $this->getRequest()->getParam('coid');
		$del = $model -> deleteInfo('comment', 'coid='.$coid);
		if($del){
			$this -> forward('admin','comment','index');
		}
		return false;
	}
}