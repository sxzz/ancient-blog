<?php

namespace app\common\model;

use think\Model;

class Article extends Model
{
    public function getArticles($getNum)
    {
        return $this->order(['top' => 'DESC', 'time' => 'DESC'])->limit($getNum)->select();
    }

    public function getArticle($id)
    {
        return $this->where('id', $id)->find();
    }
    public function addViews($id)
    {
        return $this->where('id', $id)->setInc('views', 1);
    }
    public function deleteArticle($id)
    {
        return $this->where('id', $id)->delete() > 0;
    }
    public function getArticleMarkdown($id)
    {
        return $this->where('id', $id)->value('markdown');
    }
    public function addArticle($title, $markdown, $alias)
    {
        $result = $this->data([
            'title'    => $title,
            'markdown' => $markdown,
            'alias'    => $alias,
        ])->save();
        if ($result !== false) {
            return [true, $this->id];
        } else {
            return [false];
        }
    }
}
