<?php

class ArticleController extends Yaf\Controller_Abstract{
	public function IndexAction(){
		$model = new AdminModel();
		$art = $model -> getInfo('article');
		$art = $model -> getTag($art);
		$art = $model -> getCategory($art);
		$this->getView()->assign('art', $art);
		return true;
	}
	public function AddAction(){
		$model = new AdminModel();
		if($this->getRequest()->isPost()){
			$post = $this->getRequest()->getPost();
			if(!isset($post['cid'])){
				die('请输入完整信息');
			}
			if(!isset($post['tid'])){
				die('请输入完整信息');
			}
			if(!isset($post['content'])){
				die('请输入完整信息');
			}
			$model = new AdminModel();
			$array = $post;
			$array['time'] = time();
			$tid = $array['tid'];
			$cid = $array['cid'];
			$content = $array['content'];
			unset($array['content']);
			unset($array['tid']);
			unset($array['cid']);	
			$char = implode("','", $array);
			$str = "('".$char."')";
			$aid = $model->add('article', $str,'title,author,digest,time');
			foreach ($cid as $v){
				$addCate = $model->add('art_cate', "('".$aid."','".$v."')","article_aid,category_cid");
			}
			foreach ($tid as $v){
				$addTag = $model->add('art_tag', "('".$aid."','".$v."')","article_aid,tag_tid");
			}
			$addContent = $model->add('content',"('".$content."','".$aid."')","content,aid");
			
			return false;
		}
		$tag = $model -> getInfo('tag');
		$this -> getView() -> assign('tag', $tag);
		$cate = $model -> getInfo('category');
		$this -> getView() -> assign('cate', $cate);
		return true;
	}
	public function delAction(){
		$model = new AdminModel();
	 	$aid = $this->getRequest()->getParam('aid');
		$del = $model -> deleteInfo('article','aid='.$aid);
		$del = $model -> deleteInfo('content','aid='.$aid);
		if($del){
			$this -> forward('admin','article','index');
		}
		return false;
	}
}
