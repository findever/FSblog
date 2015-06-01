<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-6-1 14:37:05
 * @Description 系统管理
 */

namespace Admin\Controller;

use Admin\Controller\BaseController;

class SystemController extends BaseController {

	public function index() {
		$this->show('system index');
	}

	public function config() {
		$this->show('system config');
	}

}
