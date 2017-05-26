# 介绍
个人的博客系统，功能目前尚未完成，本人时间比较少，慢慢写... ╮(╯_╰)╭

基于 `ThinkPHP 5.0` 框架开发。

本博客遵循`Apache2`开源协议发布，并提供免费使用。

# 食用方法
1. 下载后直接上传至您的服务器
2. 设置项目入口文件 `public/index.php`
3. 配置好应用根目录下的`.env`文件
4. 打开后台进行进一步配置（后台地址 `www.example.com/admin`）

## 注意事项
### 关闭调试模式

在服务器上部署建议关闭`应用调试`、`应用Trace`以及`数据库调试模式`（修改`.env` 中 `debug = 0`、`trace = 0`）

### 修改入口文件

如果你的服务器为虚拟主机或项目入口文件为`public/index.php`，则需要修改入口文件至根目录

1. 修改`public/index.php`，`require __DIR__ . '/../thinkphp/start.php';` 修改为 `require './thinkphp/start.php';`

2. 把应用根目录下的 `public` 文件夹的所有文件移动至应用根目录下。 

# 开发进度
- [x] 前台重构代码
- [x] 显示浏览数
- [x] 增加按钮图标
- [x] 文章置顶功能
- [ ] 后台管理
	- [x] 后台登录
	- [ ] 权限验证
	- [ ] 文章管理
		- [x] 文章列表
		- [x] 文章分页
		- [x] 添加文章
		- [x] 编辑文章
		- [x] 删除文章
		- [ ] 搜索文章
		- [ ] 文章别名 (以后重构)
		- [ ] 文章添加/编辑时自动备份
	- [ ] 分类管理
		- [ ] 分类列表
		- [ ] 添加分类
		- [ ] 删除分类
		- [ ] 编辑分类
	- [ ] 友链管理
		- [ ] 友链列表
		- [ ] 友链分页
		- [ ] 添加友链
		- [ ] 删除友链
		- [ ] 编辑友链
	- [ ] 博客信息编辑
	- [ ] 博客背景编辑（每天一换、随机背景）
	- [ ] 使用pjax
- [ ] 文章搜索
- [x] 文章分页
- [ ] 文章分类
- [ ] 404 页面
- [ ] 背景音乐功能
- [ ] 移动设备优化

## To Do List
- 后台-文章分页
- 前后台-搜索文章