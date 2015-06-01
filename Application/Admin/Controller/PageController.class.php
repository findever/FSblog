<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-6-1 14:39:13
 * @Description 页面管理
 */

namespace Admin\Controller;

use Admin\Controller\BaseController;

class PageController extends BaseController {

	public function index() {
		$this->assign('pages',$this->_getAllPages());
		$this->display();
	}
	
	/**
	 * 获取所有页面
	 * @access private
	 * @return Array
	 */
	private function _getAllPages(){
		return M('page')->order('id desc')->select();
	}

}
