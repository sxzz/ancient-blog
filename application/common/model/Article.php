<?php

namespace app\common\model;

use think\Model;

class Article extends Model
{
    protected $autoWriteTimestamp = true;
    public function getArticles($page, $itemNum)
    {
        return $this->order(['top' => 'desc', 'create_time' => 'desc'])->paginate($itemNum, null, ['page' => $page]);
    }

    public function getArticle($id)
    {
        return $this->where('id', $id)->field(['id', 'title', 'create_time', 'markdown', 'views'])->find();
    }
    public function addViews($id)
    {
        return $this->where('id', $id)->setInc('views', 1);
    }
    public function deleteArticle($id)
    {
        return $this->where('id', $id)->delete() > 0;
    }
    public function addArticle($id, $title, $markdown)
    {
        $result = $this->validate(true)->save([
            'id'       => $id,
            'title'    => $title,
            'markdown' => $markdown,
        ]);
        if ($result !== false) {
            return [true, $this->id];
        } else {
            return [false, $this->getError()];
        }
    }
    public function modArticle($id, $title, $markdown)
    {
        $this->isUpdate(true);
        $result = $this->save([
            'title'    => $title,
            'markdown' => $markdown,
        ], ['id' => $id]);
        return $result !== false;
    }
}
