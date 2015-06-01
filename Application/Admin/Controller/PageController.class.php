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
		$this->show('page index');
	}

}
