<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-6-1 14:27:47
 * @Description 文章管理基类
 */

namespace Admin\Controller;

use Admin\Controller\BaseController;

class PostController extends BaseController {

	/**
	 * 文章管理列表
	 * @access public
	 */
	public function index() {
		list($posts, $show) = $this->_getLastPosts(I('get.p'), 15);
		$this->assign("posts", $posts);
		$this->assign("pagination", $show);
		$this->display();
	}

	/**
	 * 新增文章
	 * @access public
	 */
	public function add() {
		$this->display('update');
	}

	/**
	 * 修改文章
	 * @access public
	 */
	public function update() {
		
	}

	/**
	 * ueditor后台接口
	 * @access public
	 */
	public function ueditor() {
		$data = new \Org\Util\Ueditor();
		C('SHOW_PAGE_TRACE',false);
		$this->show($data->output());
	}

	/**
	 * 获取指定id文章的信息
	 * @access private
	 * @param Int $id 文章ID
	 * @return Array 文章信息数组
	 */
	private function _getPostById($id) {
		return M('post')->where("id=" . $id)->find();
	}

	/**
	 * 获取最新文章列表
	 * @access private
	 * @param Int $p 页码
	 * @param Int $size 分页大小，默认15
	 * @return Array 文章列表数据及文章分页
	 */
	private function _getLastPosts($p, $size = 10) {
		$postModel = M('post');
		$condition = "post_status=1";
		$count = $postModel->where($condition)->count();
		$p = intval($p);
		$p = min(max($p, 1), ceil($count / $size));
		$page = new \Think\Page($count, $size);
		$page->setConfig('first', '首页');
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$page->setConfig('last', '末页');
		$page->lastSuffix = false;
		$show = $page->show();
		$posts = $postModel->where($condition)->page($p)->limit($size)->order('id desc')->select();
		return array($posts, $show);
	}

}
