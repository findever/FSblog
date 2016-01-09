<?php

/**
 * @author Findever
 * @link ifindever.com
 * @datetime 2015-6-22 11:31:25
 * @Description 导航管理控制器
 */

namespace Admin\Controller;

use Think\Model;

/**
 * 导航管理控制器
 */
class NavController extends BaseController {
	/**
	 * 导航管理列表
	 * @access public
	 */
	public function index() {
		$navs = M("nav")->select();
		$this->assign("navs", $navs);
		$this->display();
	}

	/**
	 * 新增导航
	 * @access public
	 */
	public function add() {
		$this->display("update");
	}

	/**
	 * 修改导航
	 * @access public
	 */
	public function update() {
		$id = intval(I('get.id'));
		$nav = M('nav')->where("id=" . $id)->find();
		empty($nav) && $this->error("导航不存在或已删除");

		$this->assign('nav', $nav);
		$this->display();
	}

	/**
	 * 保存导航
	 * @access public
	 */
	public function save() {
		$navModel = M('nav');

		if (!$navModel->create()) {
			$this->error("操作失败" . $navModel->getError());
		}

		if (!empty(I('post.id'))) {
			if (!$navModel->save())
				$this->error("更新失败" . $navModel->getDbError());
		} else if (!$navModel->add()) {
			$this->error("添加失败" . $navModel->getDbError());
		}

		$this->success("操作成功！", U('Nav/index'));
	}
}
