<?php

namespace app\admin\controller;

use think\Request;

class Article
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $articles = model('Article')->getArticles(config('db_data.ADMIN_PAGE_NUM')); // 获取文章列表

        return view(null, ['articles' => $articles]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('edit', ['action' => 'save']);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $title          = $request->post('title');
        $markdown       = $request->post('markdown');
        $alias          = $request->post('alias');
        list($res, $id) = model('Article')->addArticle($title, $markdown, $alias);
        return ['status' => $res ? 1 : 0, 'id' => $id];
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        return redirect('index/index/article', ['id' => $id]);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $article = model('Article')->getArticle($id);
        return view(null, ['article' => $article, 'action' => 'update']);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $title    = $request->put('title');
        $markdown = $request->put('markdown');
        $alias    = $request->put('alias');
        $res      = model('Article')->modArticle($id, $title, $markdown, $alias);
        return ['status' => $res ? 1 : 0, 'id' => $id];
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $modelArticle = model('Article');

        $result = $modelArticle->deleteArticle($id);
        return json(['status' => $result ? 1 : 0]);
    }

    public function upload_img()
    {
        # code...
    }
}
