<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-6-10 21:22:17
 * @Description 文章与分类及标签对应关系模型类
 */

namespace Admin\Model;

use Think\Model;

class RelationshipModel extends Model {

	static $cateType = 'cate-post';
	static $tagType = 'tag-post';

}
