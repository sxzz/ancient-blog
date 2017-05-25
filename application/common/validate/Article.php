<?php

namespace app\common\validate;

use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title' => 'unique:article,title,|require|max:20',
    ];

    protected $message = [
        'title.unique'  => '文章标题不能重复',
        'title.require' => '请输入文章的标题',
        'title.max'     => '标题最多不能超过 20 个字符',
    ];
}
