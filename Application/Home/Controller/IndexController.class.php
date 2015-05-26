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
		$this->assign("posts", $this->_getLastPosts());
		$this->assign("topNav", $this->_getTopNav());
		$this->display();
	}

	/**
	 * 获取文章列表
	 * @access private
	 * @return Array 文章列表
	 */
	private function _getLastPosts() {
		$postModel = D('post');
		$posts = $postModel->where("post_status=0")->limit(10)->select();
		return $posts;
	}

}
