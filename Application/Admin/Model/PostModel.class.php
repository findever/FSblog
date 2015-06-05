<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-6-4 9:56:00
 * @Description 文章模型类
 */

namespace Admin\Model;

use Think\Model;

class PostModel extends Model {

	protected $_validate = array(
		array('post_author', '', '帐号名称已经存在！', 0, 'unique', 1), // 在新增的时候验证name字段是否唯一
		array('post_date', array(1, 2, 3), '值的范围不正确！', 2, 'in'), // 当值不为空的时候判断是否在一个范围内
		array('post_title', 'password', '确认密码不正确', 0, 'confirm'), // 验证确认密码是否和密码一致
		array('post_content', 'checkPwd', '密码格式不正确', 0, 'function'), // 自定义函数验证密码格式
		array('post_status', 'checkPwd', '密码格式不正确', 0, 'function') // 自定义函数验证密码格式
	);
	protected $_auto = array();

}
