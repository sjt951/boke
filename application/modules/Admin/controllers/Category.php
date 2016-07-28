<?php

class CategoryController extends Yaf\Controller_Abstract{
	public function IndexAction(){
		$model = new AdminModel();
		$cate = $model->getInfo('category');
		$this->getView()->assign('cate', $cate);
		return true;
	}
	public function addAction(){
		if($this->getRequest()->isPost()){
			$model = new AdminModel();
			$array = $this->getRequest()->getPost();
			$char = implode("','", $array);
			$str = "('".$char."')";
			$add = $model->add('category',$str,'cname');
			if($add){
				$this->forward('admin','category','index');
			}
		}
		return false;
	}
	public function delAction(){
		$model = new AdminModel();
	 	$cid = $this->getRequest()->getParam('cid');
		$del = $model -> deleteInfo('art_cate', 'category_cid='.$cid);
		$del = $model -> deleteInfo('category','cid='.$cid);
		if($del){
			$this -> forward('admin','category','index');
		}
		return false;
	}
}