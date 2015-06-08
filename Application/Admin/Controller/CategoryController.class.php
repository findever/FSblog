<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-6-2 20:04:24
 * @Description 文章分类基类
 */

namespace Admin\Controller;

use Admin\Controller\BaseController;

class CategoryController extends BaseController {

	public function index() {
		
	}

	/**
	 * 获取分类列表，ajax返回json数据
	 * @access public
	 */
	public function ajaxList() {
		$data = M('category')->where('id>2')->select();
		$this->ajaxReturn($data);
	}

}
