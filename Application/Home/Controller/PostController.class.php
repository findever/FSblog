<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-5-25 11:40:06
 * @Description
 */

namespace Home\Controller;

/**
 * 文章控制器基类
 */
class PostController extends BaseController {

	/**
	 * 文章页面
	 * @access public
	 */
	public function index() {
		$postId = I('get.id', 0, 'intval');
		$post = $this->_getPostById($postId);
		if(empty($post)){
			$this->error("对不起，文章不存在或已删除！");
		}
		list($prevPost,$nextPost) = $this->_getAdjoinPost($postId);
		$this->assign('prevPost',$prevPost);
		$this->assign('nextPost',$nextPost);
		$this->assign('post', $post);
		$this->assign("topNav", $this->_getTopNav());
		$this->display();
	}
	
	/**
	 * 刷新文章的缩略图和摘要，辅助更新数据用
	 * @access public
	 */
	public function flush(){
		$postModel = M('post');
		$data = $postModel->select();
		$total = count($data);
		$successCount = 0;
		$errorCount = 0;
		foreach($data as &$v){
			$v['post_thumbnail'] = '/Public/img/default_post_thumbnail.png';
			$v['post_remark'] = mb_substr(trim(strip_tags($v['post_content'])), 0, 300,'utf-8');
			unset($v['post_content']);
			if($postModel->save($v) !== false){
				$successCount ++;
			}else{
				$errorCount ++;
			}
		}
		echo "总数：",$total," ，成功数：",$successCount," ，失败数：",$errorCount;
		exit();
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
	 * 获取指定id文章的上下文章
	 * @access private
	 * @param Int $postId 文章id
	 * @return Array 上下文章
	 */
	private function _getAdjoinPost($postId){
		$postModel = M('post');
		$prev = $postModel->where('post_status=1 and id>'.$postId)->field('id,post_title')->find();
		$next = $postModel->where('post_status=1 and id<'.$postId)->field('id,post_title')->order('id desc')->find();
		return array($prev,$next);
	}

}
