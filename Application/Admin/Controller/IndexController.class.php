<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-5-30 20:37:14
 * @Description 后台入口
 */

namespace Admin\Controller;

use Admin\Controller\BaseController;

class IndexController extends BaseController {

	public function index() {
		$this->show('xxx');
	}

	public function login() {
		session('user','');
		$defaultVals = array('user' => 'admin', 'pwd' => 'admin', 'notice' => '');
		if (IS_POST && I('post.user')) {
			try {
				$userModel = M("Users"); // 实例化User对象
				// 令牌验证
				if (!$userModel->autoCheckToken($_POST)) {
					throw new \Exception('非法提交，请重新进入页面！');
				}
				$condition = array();
				$condition['user'] = I('post.user');
				$condition['pwd'] = md5(I('post.pwd'));
				$condition['status'] = 1;
				$user = $userModel->where($condition)->find();
				if (empty($user)) {
					throw new \Exception('用户名或密码不正确！');
				}
				session('user', $user['user']);
				$this->redirect('Index/index');
			} catch (\Exception $e) {
				$defaultVals['notice'] = $e->getMessage();
			}
		}
		$this->assign('defaultVals', $defaultVals);
		$this->display('login');
	}

	public function unlogin() {
		session('user',null);
		$this->login();
	}

}
