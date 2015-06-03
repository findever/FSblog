<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-6-2 20:04:24
 * @Description 标签分类基类
 */

namespace Admin\Controller;

use Admin\Controller\BaseController;

class TagController extends BaseController {

	public function index() {
		
	}

	/**
	 * 获取标签列表，ajax返回json数据
	 * @access public
	 */
	public function ajaxList() {
		$data = M('tag')->select();
		$this->ajaxReturn($data);
	}

}
