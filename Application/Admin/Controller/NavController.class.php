<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-6-22 11:31:25
 * @Description 导航管理控制器
 */

namespace Admin\Controller;

use Admin\Controller\BaseController;

/**
 * 导航管理控制器
 */
class NavController extends BaseController {
	public function index(){
		$navs = M("nav")->select();
		$this->assign("navs",$navs);
		$this->display();
	}
}
