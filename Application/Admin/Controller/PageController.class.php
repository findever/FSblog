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
	
	/**
	 * 页面管理首页
	 * @access public
	 */
	public function index() {
		$this->assign('pages', $this->_getAllPages());
		$this->display();
	}
	
	/**
	 * 新增页面
	 * @access public
	 */
	public function add(){
		$this->display('update');
	}
	
	/**
	 * 修改页面
	 * @access public
	 */
	public function update(){
		$this->display();
	}

	/**
	 * 获取所有页面
	 * @access private
	 * @return Array
	 */
	private function _getAllPages() {
		return M('page')->order('id desc')->select();
	}

}
