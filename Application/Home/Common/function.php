<?php

/**
 * @author Findever 
 * @link ifindever.com 
 * @datetime 2015-5-27 15:09:09
 * @Description 公用函数
 */

/**
 * 将时间转换为友好的【一天前】类型
 * @param String|Int $date 需要转换的时间（可以为时间字符串或时间戳）
 * @return String 转换后的时间
 */
function dateToFriendlyWords($date) {
	if (!$date) {
		return '';
	}

	// 先转换为时间戳
	if (!preg_match('/^\d+$/', $date)) {
		$date = strtotime($date);
	}

	// 与当前时间差值
	$diff = time() - $date;

	$friendlyRuleArr = array("年" => 31536000, "个月" => 2592000, "星期" => 604800, "天" => 86400, "小时" => 3600, "分钟" => 60, "秒" => 1);
	if ($diff < 0) {
		return Date('Y-m-d', $date);
	}
	foreach ($friendlyRuleArr as $k => $v) {
		if (0 != $c = floor($diff / $v)) {
			return $c . $k . '前';
		}
	}
}
