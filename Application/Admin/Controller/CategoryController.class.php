<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-6-2 20:04:24
 * @Description 文章分类基类
 */

namespace Admin\Controller;

use Admin\Controller\BaseController;

class CategoryController extends BaseController {

	public function index() {
		$cates = M('category')->where("id>=" . \Admin\Model\CategoryModel::$otherID)->select();
		$this->assign("cates", $cates);
		$this->display();
	}

	/**
	 * ajax快速添加分类
	 * @access public
	 */
	public function ajaxAdd() {
		$cateModel = D('category');

		$result = array(
			"status" => 0,
			"msg" => "添加成功！"
		);

		if (!$cateModel->create()) {
			$result = array(
				"status" => 1,
				"msg" => $cateModel->getError()
			);
		} else {
			if (!$cateModel->add()) {
				$result = array(
					"status" => 2,
					"msg" => "添加失败".$cateModel->getDbError()
				);
			}
		}

		$this->ajaxReturn($result);
	}

	/**
	 * 获取分类列表，ajax返回json数据
	 * @access public
	 */
	public function ajaxList() {
		$data = M('category')->where('id>2')->select();
		$this->ajaxReturn($data);
	}

}
