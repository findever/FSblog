<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-5-30 20:37:14
 * @Description 后台基类
 */

namespace Admin\Controller;

use Think\Controller;

class BaseController extends Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->auth() && __ACTION__ !== '/Admin/Index/login'){
			$this->redirect('Index/login');
			return;
		}
	}
	
	/**
	 * 登录权限验证
	 */
	public function auth() {
		return session('user');
	}
	
	/**
	 * Ueditor后台接口
	 * @access public
	 */
	public function ueditor() {
		$data = new \Org\Util\Ueditor();
		C('SHOW_PAGE_TRACE', false);
		$this->show($data->output());
	}

}