<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-5-26 21:42:20
 * @Description
 */

namespace Home\Controller;

use Think\Controller;

/**
 * 控制器基类
 */
class BaseController extends Controller {

	/**
	 * 获取顶部导航列表
	 * @access protected
	 * @return Array
	 */
	protected function _getTopNav() {
		return array(
			"首页" => "/",
			"DEMO" => "/demo",
			"关于" => "/about.php",
			"留言" => "/guessbook.php"
		);
	}

}
