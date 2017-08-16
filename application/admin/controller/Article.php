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
    public function index(Request $request)
    {
        $page     = $request->get('p', 1);
        $articles = model('Article')->getArticles($page, 20); // 获取文章列表
        if ($articles->lastPage() > 0 && $articles->lastPage() < $page) {
            return redirect('admin/article/index');
        }
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
        $id             = substr(md5($title), 8, 16);
        $markdown       = $request->post('markdown');
        list($res, $id) = model('Article')->addArticle($id, $title, $markdown);
        if ($res) {
            return ['status' => 1, 'id' => $id];
        } else {
            return ['status' => 0, 'msg' => $id];
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        return redirect(url('index/index/article', ['id' => $id]));
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
        $res      = model('Article')->modArticle($id, $title, $markdown);
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
