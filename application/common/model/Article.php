<?php

namespace app\common\model;

use think\Model;

class Article extends Model
{
    protected $autoWriteTimestamp = true;
    public function getArticles($getNum)
    {
        return $this->order(['top' => 'desc', 'create_time' => 'desc'])->limit($getNum)->select();
    }

    public function getArticle($id)
    {
        return $this->where('id', $id)->field(['id', 'title', 'create_time', 'markdown', 'views', 'alias'])->find();
    }
    public function addViews($id)
    {
        return $this->where('id', $id)->setInc('views', 1);
    }
    public function deleteArticle($id)
    {
        return $this->where('id', $id)->delete() > 0;
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
    public function modArticle($id, $title, $markdown, $alias)
    {
        $this->isUpdate(true);
        $result = $this->save([
            'title'    => $title,
            'markdown' => $markdown,
            'alias'    => $alias,
        ], ['id' => $id]);
        return $result !== false;
    }
}
