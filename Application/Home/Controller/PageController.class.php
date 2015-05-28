<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-5-28 22:28:32
 * @Description 单页基类
 */
namespace Home\Controller;

use Home\Controller\BaseController;

/**
 * 单页基类
 */
class PageController extends BaseController{
	
	/**
	 * 空方法，用于接收所有请求
	 * @param String $name 页面标识
	 */
	public function _empty($name){
		$this->show($name);
	}
	
	/**
	 * 查询并显示对应的单页面
	 * @param String $name 页面标识
	 */
	protected function show($name){
		die($name);
	}
}