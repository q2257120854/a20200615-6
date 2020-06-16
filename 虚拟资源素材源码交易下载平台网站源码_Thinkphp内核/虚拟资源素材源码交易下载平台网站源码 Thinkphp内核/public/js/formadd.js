layui.use(['element', 'form', 'upload', 'layedit'], function () {
    var editor;
    var layedit;
    var form = layui.form,
        element = layui.element,
        upload = layui.upload,
        jq = layui.jquery,
        layedit = layui.layedit;
    layedit.set({
        //暴露layupload参数设置接口 --详细查看layupload参数说明
        uploadImage: {
            url: "/index/upload/upimage",
            accept: 'image',
            acceptMime: 'image/*',
            exts: 'jpg|png|gif|bmp|jpeg',
            size: '10240'
        }
        //开发者模式 --默认为false
        , devmode: true
        //插入代码设置
        , codeConfig: {
            hide: true,  //是否显示编码语言选择框
            default: 'javascript' //hide为true时的默认语言格式
        }
        , tool: [
            'code', 'strong', 'italic', 'underline', 'del', 'addhr', '|', 'fontFomatt', 'colorpicker', 'face'
            , '|', 'left', 'center', 'right', '|', 'link', 'unlink', 'image_alt', 'images', 'video', 'anchors', 'html'

        ]
        , height: '90%'
    });
    editor = layedit.build('content');

    upload.render({
        elem: '#image',
        url: "/admin/upload/upimage",
        before: function(obj) {
            obj.preview(function(index, file, result) {
                $('#picshow').attr('src', result);
            });
        },
        done: function(res) {
            if (res.code == '0') {
                $('#coverpic').val(res.data.headpath);
                return layer.msg('上传成功');
            } else {

                return layer.msg(res.msg);
            }

        }
    });

    form.verify({
        content: function (value) {
            return layedit.sync(editor);
        },
        titlea: function (value) {
            if (value.length < 5) {
                return '标题必须大于5位';
            }
        },
        titleb: function (value) {
            if (value.length > 32) {
                return '标题必须小于32位';
            }
        }
    });





    var url = jq('form').data('url');
    var locationurl = jq('form').attr('localtion-url');
    jq('.layui-form').append('<input type="hidden" name="token" value="' + token + '">');
    form.on('submit(formadd)', function (data) {
        loading = layer.load(2, {
            shade: [0.2, '#000']
        });
        var param = data.field;
        jq.post(url, param, function (data) {
            if (data.code == 200) {
                layer.close(loading);
                layer.msg(data.msg, { icon: 1, time: 1000 }, function () {
                    location.href = locationurl;
                });
            } else {
                layer.close(loading);
                layer.msg(data.msg, { icon: 2, anim: 6, time: 1000 });
            }
        });
        return false;
    });
})