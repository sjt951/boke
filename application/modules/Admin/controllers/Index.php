<?php
use Yaf\Request_Abstract;
class IndexController extends Yaf\Controller_Abstract{
	public function IndexAction(){
		$session=Yaf\Session::getInstance();
		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if($post['username']=='admin' && $post['passwd']=='123123'){
				$session->admin == 1;
				return true;
			}
		}
		if($session->admin == 1){
			return true;
		}else{
			$this->forward('admin','index','login');
		}
		return false;
	}
	public function LoginAction(){
		return true;
	}
	public function WelcomeAction(){
		return true;
	}
}