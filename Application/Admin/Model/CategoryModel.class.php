<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-6-10 21:22:17
 * @Description 分类模型类
 */

namespace Admin\Model;

use Think\Model;

class CategoryModel extends Model {

	static $recycleID = 1;
	static $draftID = 2;
	static $otherID = 3;
	protected $_validate = array(
		array('id', 'number', '非法更新！', self::VALUE_VALIDATE),
		array('cate_name', 'require', '分类名称不能为空', self::MUST_VALIDATE),
		array('cate_name', '', '分类名称已存在', self::MUST_VALIDATE, "unique"),
		array('cate_name', '1,10', '分类名称长度不能超过10个字符', self::MUST_VALIDATE, 'length')
	);
	protected $_auto = array(
		array('is_system', 0, self::MODEL_BOTH, 'string'),
		array('parent_id', 0, self::MODEL_BOTH, 'string')
	);

}
