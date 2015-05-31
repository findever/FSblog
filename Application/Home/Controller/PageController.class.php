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
	
	// 定义模块url
	private $_modules = array('Admin','Home');

	/**
	 * 空方法，用于接收所有请求
	 * @param String $name 页面标识
	 */
	public function _empty($name){
		if($_SERVER['PATH_INFO'] === $name && in_array($name, $this->_modules)){
			redirect(U($name.'/Index/index'));
			return;
		}
		$this->go($name);
	}
	
	/**
	 * 查询并显示对应的单页面
	 * @param String $name 页面标识
	 */
	protected function go($name){
		$page = M('page')->where('page_sign="'.$name.'" and page_status=1')->find();
		if(empty($page)){
			$this->error("404 - 客官对不起，我们已经努力找过了，没发现您要的页面：（","/");
		}
		
		// 如果设置了跳转链接，则直接跳转
		if($page['page_url']){
			redirect($page['page_url']);
			return;
		}
		
		// TODO 显示单页页面内容
	}
}