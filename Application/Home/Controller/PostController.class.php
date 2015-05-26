<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-5-25 11:40:06
 * @Description
 */

namespace Home\Controller;

/**
 * 文章控制器基类
 */
class PostController extends BaseController {

	/**
	 * 文章页面
	 * @access public
	 */
	public function index() {
		$postId = I('get.id', 0, 'intval');
		$this->assign('post', $this->_getPostById($postId));
		$this->assign("topNav", $this->_getTopNav());
		$this->display();
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

}
