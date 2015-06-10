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
	
	static $recycleC = 1;
	static $draftC = 2;
	static $otherC = 3;

	protected $_validate = array(
		array('id', 'number', '非法更新！', self::VALUE_VALIDATE, 'unique', self::MODEL_UPDATE),
		array('post_title', 'require', '标题不能为空', self::MUST_VALIDATE),
		array('post_title', '1,50', '标题长度不能超过50个字符', self::MUST_VALIDATE, 'length'),
		array('post_from', '/^https?:\/\/[^\s]+$/i', '转载来源必须为url链接，且不超过100个字符', self::VALUE_VALIDATE, 'regex'),
		array('post_status', array(0, 1), '状态值范围不正确', self::MUST_VALIDATE, 'in'),
		array('post_cats', '/^(\d+,)*\d+$/', '分类值不正确', self::VALUE_VALIDATE, 'regex'),
		array('post_remark', '1,300', '摘要不能超过300个字符', self::VALUE_VALIDATE, 'length'),
	);
	protected $_auto = array(
		array('post_date','getCurrDate',self::MODEL_INSERT,'function'),
		array('post_update_date','getCurrDate',self::MODEL_BOTH,'function'),
	);

}
