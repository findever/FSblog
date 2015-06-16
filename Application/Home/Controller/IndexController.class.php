<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-5-25 21:42:20
 * @Description
 */

namespace Home\Controller;

/**
 * 首页控制器基类
 */
class IndexController extends BaseController {

	/**
	 * 首页页面
	 * @access public
	 */
	public function index() {
		list($posts, $show) = $this->_getLastPosts(I('get.p'));
		$this->assign("posts", $posts);
		$this->assign("pagination", $show);
		$this->assign("topNav", $this->_getTopNav());
		$this->assign("thumbnail", PostController::_getDeafultPostThumbnail());
		$this->display();
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
