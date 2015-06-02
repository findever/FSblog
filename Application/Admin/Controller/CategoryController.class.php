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
//		$cateModel = M('category');
		$data = array(
			array('id' => 1, "cate_name" => "sdfd"),
			array('id' => 2, "cate_name" => "大幅度"),
			array('id' => 3, "cate_name" => "塞得更多"),
		);
		$this->ajaxReturn($data);
	}

}
