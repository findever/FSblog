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
		$id = intval(I('get.id'));
		$post = M('post')->where("id=" . $id)->find();
		empty($post) && $this->error("文章不存在或已删除");
		
		// 获取文章的分类及标签
		$cates = M("relationship")->join('category on relationship.bid=category.id')->where('aid='.$id)->getField("category.id,category.cate_name");
		$post['post_cates_text'] = implode(",", $cates);
		$post['post_cates'] = implode(",", array_keys($cates));
		$post['post_tags'] = M("relationship")->join('tag on relationship.bid=tag.id')->where('aid='.$id)->getField("tag.tag_name",",");
		
		$this->assign("post", $post);
		$this->display();
	}

	/**
	 * 保存文章
	 * @access public
	 */
	public function save() {
		$postModel = D('post');
		if (!$postModel->create()) {
			$this->error($postModel->getError());
		}

		// 摘要处理
		$content = $postModel->post_content;
		!$postModel->post_remark && $postModel->post_remark = mb_substr(trim(strip_tags($content)), 0, 300, 'utf-8');

		// 分类处理, 默认为未分类
		$postCates = I('post.post_cates');
		$cates = $postCates ? explode(',', $postCates) : array();
		empty($cates) && $cates = array(\Admin\Model\CategoryModel::$otherID);

		// @fixme 标签处理
		$tags = $postModel->post_tags ? explode(',', $postModel->post_tags) : array();

		// 缩略图处理
		if ($_FILES['post_thumbnail_file']['name']) {
			$config = array(
				'maxSize' => 524288, // 0.5M
				'rootPath' => './Uploads/',
				'savePath' => "post/",
				'saveName' => array('uniqid', ''),
				'exts' => array('jpg', 'gif', 'png', 'jpeg'),
				'autoSub' => true,
				'subName' => array('date', 'Ymd')
			);
			$upload = new \Think\Upload($config); // 实例化上传类
			$info = $upload->uploadOne($_FILES['post_thumbnail_file']);
			if (!$info) {
				$this->error("缩略图上传失败：" . $upload->getError());
			}
			$filePath = "/Uploads/" . $info['savepath'] . $info['savename'];
			// 生成缩略图
			$image = new \Think\Image();
			$image->open("." . $filePath);
			$image->thumb(100, 100, \Think\Image::IMAGE_THUMB_FIXED)->save("." . $filePath);
			$postModel->post_thumbnail = $filePath;
		}

		// 事务之前先准备好资源
		$relaModel = M('relationship');
		$relaData = array();
		$postId = $postModel->id;

		// 开启事务
		$postModel->startTrans();
		try {
			// 删除原有文章分类
			if ($postModel->id) {
				$relaModel->where('aid=' . $postModel->id)->delete();
				// 更新文章
				if (false === $postModel->save()) {
					throw new \Think\Exception("更新文章出错");
				}
			} else {
				if (false === ($postId = $postModel->add())) {
					throw new \Think\Exception("保存文章出错");
				}
			}
			$postId = $postId;
			// 保存分类及标签
			for ($i = 0, $len = count($cates); $i < $len; $i++) {
				$relaData[] = array('type' => \Admin\Model\RelationshipModel::$cateType, 'aid' => $postId, 'bid' => $cates[$i]);
			}
			for ($i = 0, $len = count($tags); $i < $len; $i++) {
				$relaData[] = array('type' => \Admin\Model\RelationshipModel::$tagType, 'aid' => $postId, 'bid' => $tags[$i]);
			}

			if (false === ($relaModel->addAll($relaData))) {
				throw new \Think\Exception("保存文章分类或标签出错出错");
			}
		} catch (\Think\Exception $e) {
			$this->error($e->getMessage());
			$postModel->rollback();
		}
		$postModel->commit();
		$this->success("保存成功");
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
		$condition = "post_status<2";
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
	private function _getAllCateIds() {
		return M('category')->where('id>3')->getField('id');
	}

}
