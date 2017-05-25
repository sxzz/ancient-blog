$(function() {
    $.ajaxSetup({
        cache: true // 设置缓存，节省资源
    });
    // 读取body data-type 判断是哪个页面然后执行相应页面方法。
    var dataType = $('body').data('type');
    console.log(dataType);
    for (key in pageData) {
        if (key == dataType) {
            pageData[key]();
        }
    }
    // 给导航条设置当前项
    $("[data-action*='" + dataType + "'] a").addClass('active');
    autoLeftNav();
    $(window).resize(function() {
        autoLeftNav();
    });
    if ($('.am-switch').length > 0) {
        // 如果引入了switch组件则引入相应的JS和CSS
        $.getScript('/static/js/amazeui.switch.js');
        addCss('/static/css/amazeui.switch.css');
    }
    // 风格切换
    $('.tpl-skiner-toggle').on('click', function() {
        $('.tpl-skiner').toggleClass('active');
    });
    $('.tpl-skiner-content-bar').find('span').on('click', function() {
        $('body').attr('class', $(this).attr('data-color'))
        saveSelectColor.Color = $(this).attr('data-color');
        // 保存选择项
        storageSave(saveSelectColor);
    });
    // 侧边菜单
    $('.sidebar-nav-sub-title').on('click', function() {
        $(this).siblings('.sidebar-nav-sub').slideToggle(80).end().find('.sidebar-nav-sub-ico').toggleClass('sidebar-nav-sub-ico-rotate');
    });
})
// 页面数据
var pageData = {
    login: function() {
        $('#formLogin').submit(function() {
            $('#btnLogin').button('loading');
            $.ajax({
                url: '/admin/login/ajax_login',
                type: 'POST',
                dataType: 'json',
                data: {
                    account: $('#inputAccount').val(),
                    pwd: $('#inputPwd').val(),
                },
            }).done(function(result) {
                if (result.status == 1) {
                    // 登录成功，跳转到后台
                    layer.msg(result.msg, {
                        time: 500,
                    }, function() {
                        location = "/admin";
                    });
                } else {
                    // 登录失败
                    layer.alert(result.msg, {
                        icon: 2,
                    }, function(index) {
                        $('#inputPwd').focus();
                        layer.close(index);
                    });
                }
            }).fail(function() {
                resultError();
            }).always(function() {
                $('#btnLogin').button('reset');
            });
            return false;
        });
    },
    article: function() {
        $("[id='btnArticleDelete']").click(function() {
            var id = $(this).data('id');
            layer.confirm('确定删除该篇文章吗？', {
                btn: ['确定', '点错了'],
                icon: 3
            }, function(index) {
                layer.close(index);
                $.ajax({
                    url: '/admin/article/' + id,
                    dataType: 'json',
                    type: 'DELETE',
                }).done(function(result) {
                    if (result.status == 1) {
                        layer.msg('删除成功！', {
                            time: 1000,
                        }, function() {
                            location.reload();
                        });
                    } else {
                        layer.alert('删除失败，也许是文章丢了呢...', {
                            icon: 2,
                        });
                    }
                }).fail(function() {
                    resultError();
                }).always(function() {});
            });
        });
    },
    articleEdit: function() {
        editormd.emoji = {
                path: "/static/editor.md/emojis/",
                ext: ".png"
            },
            editormd.twemoji = {
                path: "http://twemoji.maxcdn.com/72x72/",
                ext: ".png"
            };
        var articleEditor = editormd("editormdContent", {
            height: 650,
            path: '/static/editor.md/lib/',
            codeFold: true,
            saveHTMLToTextarea: true,
            searchReplace: true,
            htmlDecode: true,
            emoji: true,
            taskList: true,
            tocm: true, // Using [TOCM]
            tex: true, // 开启科学公式TeX语言支持，默认关闭
            flowChart: true, // 开启流程图支持，默认关闭
            sequenceDiagram: true, // 开启时序/序列图支持，默认关闭,
            imageUpload: true,
            imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL: "/admin/article/upload_img",
        });
        $('#formEditArticle').submit(function(event) {
            var title = $('#inputTitle').val();
            var markdown = articleEditor.getMarkdown();
            var alias = $('#inputAlias').val();
            if (title.trim().length == 0) {
                layer.alert('尼还木有写标题呢，写上标题再发吧！', {
                    icon: 0,
                });
                return false;
            }
            if (markdown.trim().length == 0) {
                layer.alert('尼还木有写内容呢，写点再发粗去吧！', {
                    icon: 0,
                });
                return false;
            }
            var action = $(this).data('action');
            var url = '/admin/article';
            if (action == 'update') {
                url += '/' + $("input[name='id']").val();
            }
            $('#btnSubmit').button('loading');
            $.ajax({
                url: url,
                type: action == 'save' ? 'POST' : 'PUT',
                dataType: 'json',
                data: {
                    title: title,
                    markdown: markdown,
                    alias: alias,
                },
            }).done(function(result) {
                if (action == 'save') {
                    // 添加操作
                    if (result.status == 1) {
                        layer.confirm('发布成功，是否打开文章看看？', {
                            icon: 1,
                            btn: ['是', '否'] //按钮
                        }, function(index) {
                            viewArticle(result.id);
                            layer.close(index);
                            location = "/admin/article"
                        }, function(index) {
                            layer.close(index);
                            location = "/admin/article"
                        });
                    } else {
                        layer.alert('发布失败，' + result.msg, {
                            icon: 2,
                        });
                    }
                } else {
                    if (result.status == 1) {
                        layer.confirm('编辑成功，是否打开文章看看？', {
                            icon: 1,
                            btn: ['是', '否'] //按钮
                        }, function(index) {
                            viewArticle(result.id);
                            layer.close(index);
                            location = "/admin/article"
                        }, function(index) {
                            layer.close(index);
                            location = "/admin/article"
                        });
                    } else {
                        layer.alert('编辑失败，也许是文章找不到了吧...', {
                            icon: 2,
                        });
                    }
                }
            }).fail(function() {
                resultError();
            }).always(function() {
                $('#btnSubmit').button('reset');
            });
            return false;
        });
    }
}

function viewArticle(id) {
    var tempwindow = window.open();
    tempwindow.location = '/admin/article/' + id;
}
// 服务器返回的数据错误
function resultError() {
    layer.alert("喵~ 尼的人品有问题，请反省！(请查看你的服务器有木有毛病 或 联系开发者)", {
        icon: 2,
    });
}
// 引入css文件
function addCss(url) {
    $("head").append("<link>");
    css = $("head").children(":last");
    css.attr({
        rel: "stylesheet",
        type: "text/css",
        href: url,
    });
}
// 侧边菜单开关
function autoLeftNav() {
    $('.tpl-header-switch-button').on('click', function() {
        if ($('.left-sidebar').is('.active')) {
            if ($(window).width() > 1024) {
                $('.tpl-content-wrapper').removeClass('active');
            }
            $('.left-sidebar').removeClass('active');
        } else {
            $('.left-sidebar').addClass('active');
            if ($(window).width() > 1024) {
                $('.tpl-content-wrapper').addClass('active');
            }
        }
    })
    if ($(window).width() < 1024) {
        $('.left-sidebar').addClass('active');
    } else {
        $('.left-sidebar').removeClass('active');
    }
}