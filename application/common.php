<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function get_article_url($id = null, $alias = null)
{
    if (!isset($alias)) {
        $alias = model('Article')->getAlias($id);
    }
    return url('index/index/article', empty($alias) ? ['id' => $id] : ['id' => $alias]);
}

function get_lines($str, $start, $length)
{
    return implode("\n", array_slice(explode("\n", $str), $start, $length));
}

/**
 * 换行转p标签
 * @param  string $str
 * @return string
 */
function nl2p($str)
{
    return implode('', array_map(function ($v) {
        return '<p>' . $v . '</p>';
    }, explode(PHP_EOL, $str)));
}
/**
 * 获取当前域名
 * @return string
 */
function get_domain()
{
    return input('server.HTTP_HOST');
}

/**
 * 字符串截取，支持中文和其他编码
 * static
 * access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{
    if (function_exists("mb_substr")) {
        $slice  = mb_substr($str, $start, $length, $charset);
        $strlen = mb_strlen($str, $charset);
    } elseif (function_exists('iconv_substr')) {
        $slice  = iconv_substr($str, $start, $length, $charset);
        $strlen = iconv_strlen($str, $charset);
    } else {
        $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice  = join("", array_slice($match[0], $start, $length));
        $strlen = count($match[0]);
    }
    if ($suffix && $strlen > $length) {
        $slice .= '...';
    }

    return $slice;
}
