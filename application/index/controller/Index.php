<?php
namespace app\index\controller;

class Index
{
    public function index($page = 1)
    {
        if ($page < 1) {
            return redirect('/');
        }
        $modelArticle = model('Article');

        $articles = $modelArticle->getArticles($page, 5);
        // halt($articles->hasPages());

        return view(null, ['articles' => $articles, 'page' => $page]);
    }

    public function article($id)
    {
        $modelArticle = model('Article');
        $article      = $modelArticle->getArticleByAlias($id);
        if (empty($article)) {
            $article = $modelArticle->getArticle($id);
        }
        $modelArticle->addViews($article->id);
        return view(null, ['article' => $article]);
    }
}
