<?php
namespace app\admin\controller;

use think\Request;

class Login
{
    public function index()
    {
        return view();
    }
    public function ajax_login(Request $request)
    {
        $account = $request->post('account');
        $pwd     = $request->post('pwd');

        $dataAccount = config('db_data.ADMIN_ACCOUNT');
        $dataPwd     = config('db_data.ADMIN_PWD');

        if ($dataAccount == $account && $dataPwd == $pwd) {
            cookie('admin', base64_encode(json_encode(['account' => $account, 'pwd' => $pwd])));
            return json(['status' => 1, 'msg' => '登录成功！']);
        } else {
            return json(['status' => 0, 'msg' => '账号或密码错误，如有忘记请在数据库中重置！']);
        }
    }

}
