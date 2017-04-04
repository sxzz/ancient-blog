<?php
namespace app\index\controller;

class Index extends \think\Controller
{
    public function index()
    {
        $modelArticle = model('Article');

        $articles = $modelArticle->getArticles(5);
        $this->assign('articles', $articles);
        return $this->fetch();
    }

    public function article($id)
    {
        $modelArticle = model('Article');

        $article = $modelArticle->getArticle($id);
        $modelArticle->addViews($id);
        $this->assign('article', $article);
        return $this->fetch();
    }
}
