@extends("admin.left_body")
@section("right")
    <div class="row">
        <div class="col-md-10">
            <label>文章标题</label>
            <input id="article_title" class="form-control" placeholder="标题...">
            <br>
            <label>文章内容</label>
            <textarea id="article_content" class="form-control" placeholder="## 内容" style="min-height: 200px;"></textarea>
            <p class="help-block">请填写markdown语法的文章内容，前台将自动按照markdown语法进行解析</p>
            <br>
            <label>标签</label>
            <input id="article_sign" class="form-control" placeholder="例：php redis">
            <p class="help-block">标签请使用空格隔开，最多支持5个</p>
            <br>
            <button class="btn btn-sm btn-primary" onclick="Editor.draft()">保存草稿</button>
            <button class="btn btn-sm btn-success" onclick="Editor.publish()">保存发布</button>
        </div>
    </div>
    <script>
    var Editor = (function() {

        var article_id = '';

        var _getTitle = function() {
            return document.getElementById('article_title').value;
        }

        var _getContent = function() {
            return document.getElementById('article_content').value;
        }

        var _getSign = function() {
            return document.getElementById('article_sign').value;
        }
        var _send = function(type) {
            var title = _getTitle();
            var content = _getContent();
            var sign = _getSign();

            if(!title) {
                alert('请填写标题');
                return;
            }
            if(!content) {
                alert('请填写内容');
                return;
            }

            if(type == 'draft') {
                var url = '{{ asset('admin/article/draft') }}';
            }else if(type == 'publish') {
                var url = '{{ asset('admin/article/publish') }}';
            }else {
                alert('the url is error');
                return;
            }
            $.ajax({
                type:'post',
                data:{
                    article_title:title,
                    article_content:content,
                    article_sign:sign,
                    article_id:article_id
                    },
                url:url,
                headers:{
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },
                success:function(d,s) {
                    if(d.res == 100) {
                        article_id = d.article_id;
                        alert('保存草稿成功');
                    }else {
                        alert(d.msg);
                    }
                }
            })
        }

        var draft = function() {
            _send('draft');
        }
        var publish  = function() {
            _send('publish');
        }

        return {
            draft:draft,
            publish:publish
        }
    }())
    </script>
@stop