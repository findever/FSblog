<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-6-1 14:27:47
 * @Description 文章管理基类
 */

namespace Admin\Controller;

use Admin\Controller\BaseController;

class PostController extends BaseController {

	/**
	 * 文章管理列表
	 * @access public
	 */
	public function index() {
		list($posts, $show) = $this->_getLastPosts(I('get.p'), 15);
		$this->assign("posts", $posts);
		$this->assign("pagination", $show);
		$this->display();
	}

	/**
	 * 新增文章
	 * @access public
	 */
	public function add() {
		$this->display('update');
	}

	/**
	 * 修改文章
	 * @access public
	 */
	public function update() {
		$this->display();
	}
	
	/**
	 * 保存文章
	 * @access public
	 */
	public function save(){
		$postModel = D('post');
		if(!$postModel->create()){
			$this->error($postModel->getError());
		}
		
		// 摘要处理
		$content = $postModel->post_content;
		if(!I('post.post_remark')){
			$postModel->post_remark = mb_substr(trim(strip_tags($content)), 0, 300,'utf-8');;
		}
		
		// 分类处理
		$cates = explode(',', $postModel->post_cates);
		if(empty($cates)){
			$cates = array(3);
		}
		
		// 标签处理
		$tags = explode(',', $postModel->post_tags);
		
		// 开启事务
		$postModel->startTrans();
		// 保存文章
		$postModel->save();
		// 保存分类
		
		// 保存标签
		
		
	}

	/**
	 * 批量删除文章
	 * @access public
	 */
	public function delete() {
		$ids = I('post.ids', 0, 'intval');
		$condition = array('id' => array('in', $ids));
		$postModel = M('post');
		$result = $postModel->where($condition)->delete();
		if ($result === false) {
			$errorMsg = '删除失败！';
			if (APP_DEBUG) {
				$errorMsg .= $postModel->getDbError();
			}
			$this->error($errorMsg);
		}
		if ($result === 0) {
			$this->error('没有删除任何数据！');
		}
		$this->success('成功删除 ' . $result . ' 条数据~');
	}

	/**
	 * 获取指定id文章的信息
	 * @access private
	 * @param Int $id 文章ID
	 * @return Array 文章信息数组
	 */
	private function _getPostById($id) {
		return M('post')->where("id=" . $id)->find();
	}

	/**
	 * 获取最新文章列表
	 * @access private
	 * @param Int $p 页码
	 * @param Int $size 分页大小，默认15
	 * @return Array 文章列表数据及文章分页
	 */
	private function _getLastPosts($p, $size = 10) {
		$postModel = M('post');
		$condition = "post_status=1";
		$count = $postModel->where($condition)->count();
		$p = intval($p);
		$p = min(max($p, 1), ceil($count / $size));
		$page = new \Think\Page($count, $size);
		$page->setConfig('first', '首页');
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$page->setConfig('last', '末页');
		$page->lastSuffix = false;
		$show = $page->show();
		$posts = $postModel->where($condition)->page($p)->limit($size)->order('id desc')->select();
		return array($posts, $show);
	}
	
	/**
	 * 获取所有分类的ID
	 * @access private
	 * @return Array 分类ID数组
	 */
	private function _getAllCateIds(){
		return M('category')->where('id>3')->getField('id');
	}

}
