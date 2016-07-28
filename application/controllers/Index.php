<?php

/**
 * @name IndexController
 * @author root
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class IndexController extends Yaf\Controller_Abstract {

	/** 
     * 主页
     */
	public function indexAction() {
// 		获取公共部分数据
		$this->getComent();
		
// 		获取文章数据
		$model = new IndexModel();
		$art = $model -> getInfo('article','','time desc',3);
		$this -> assignArt($art);
        return true;
	}
	
	/**
	 * 列表页
	 */	
	public function listAction(){
// 		接收路由参数
	 	$cid = $this->getRequest()->getParam('cid');
	 	$tid = $this->getRequest()->getParam('tid');
		$model = new IndexModel();
	 	
// 		按分类找文章
	 	if($cid && $cid <= 5){
	 		$model = new IndexModel();
	 		$a_c = $model -> getInfo('art_cate','category_cid='.(int)$cid,'',3);
	 		$data = array();
	 		foreach($a_c as $v ){ 		
	 			$data[] = $model -> getInfo('article','aid='.$v['article_aid'],'',3);
	 		}
	 		$data = $data[0];
// 	 	按标签找文章
	 	}else if($tid && $tid <= 7){
	 		$model = new IndexModel();
	 		$a_t = $model -> getInfo('art_tag','tag_tid='.(int)$tid,'',5);
	 		$data = array();
	 		foreach($a_t as $v ){ 		
	 			$data[] = $model -> getInfo('article','aid='.$v['article_aid'],'',3);
	 		}	 		
	 		$data = $data[0];
// 	 	时间顺序
	 	}else{
	 		$model = new IndexModel();
	 		$data = array();
	 		$art = $model -> getInfo('article','','time desc',3);
	 		foreach($art as $v ){
	 			$data[][0] = $v;
	 		}
	 		$data = $data[0];
	 	}
// 	 	分配
	 	$this -> assignArt($data);
	 	$this -> getComent();
        return true;
	}
	
	/**
	 * 文章页
	 */
	public function articleAction(){
// 		获取路由参数
		$aid = $this->getRequest()->getParam('aid');
		$model = new IndexModel();
		$art = array();
// 		如果aid存在
		if($aid){
			$art = $model->getInfo('article','aid='.$aid);
			$art = $art[0];
		}		
// 		没有对应文章 或aid不存在
		if($art == array()){
			$art = $model->getInfo('article','','time desc',1);	
			$art = $art[0];
		}
// 		找内容
		$content = $model -> getInfo('content','aid='.$art['aid']);
		$content = $content[0]['content'];
		
		
		
// 		$Parsedown = new \parsedown\Parsedown();
// 		$html = $Parsedown->text($content);

		
		$parser = new \HyperDown\Parser;		
		$html = $parser->makeHtml($content);
		
		
// 		$Markdown = new \Michelf\Markdown;
// 		$html = $Markdown->defaultTransform($content);
		
// 		分配
		$this -> getView() -> assign('content', $html);
		$this -> getView() -> assign('art', $art);
		$this -> getComent();
        return true;
	}
	
	
	/**
	 * 获取公共部分数据
	 */
	private function getComent(){
		$model = new IndexModel();
		$TagInfo = $model -> getInfo('tag');
		$CategoryInfo = $model -> getInfo('category');
		$new = $model -> getInfo('article','','time desc',5);
		$this -> getView() -> assign("new", $new);
		$this -> getView() -> assign("tag", $TagInfo);
		$this -> getView() -> assign("cate", $CategoryInfo);
	}
	
	/**
	 * 分配文章信息
	 */
	private function assignArt($art){
		$this -> getView() ->assign('art_one', $art[0]);
		$art = array_slice($art, 1);
		$this -> getView() ->assign('art', $art);
	}
}
