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
        return view(null, ['articles' => $articles]);
    }

    public function article($id)
    {
        $modelArticle = model('Article');
        $article      = $modelArticle->getArticle($id);
        if (empty($article)) {
            return "<script>alert('文章不存在！');location='/'</script>";
        }
        $modelArticle->addViews($article->id);
        return view(null, ['article' => $article]);
    }
}
