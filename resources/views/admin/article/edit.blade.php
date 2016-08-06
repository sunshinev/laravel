@extends("admin.main")
@section("right")
    <div class="row">
        <div class="col-md-10">
            <label>文章标题</label>
            <input id="article_title" class="form-control" placeholder="标题..." value="{{ $article_info->article_title }}">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12" id="category_list">
            <p>栏目关联</p>
            @foreach( $level_list as $level => $level_group)
                <div class="btn-group" id="level_{{ $level }}" style="margin-right:5px;">
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span id="action_{{ $level }}">{{ $current_list[$level]->title }}</span><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        @foreach ($level_group as $item)
                            <li><a onclick="Editor.categoryTouch('{{ $item->id }}','{{ $item->title }}')">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
            <!-- 当前文章的栏目ID -->
            <input type ='hidden' id="category_id_can_submit" value="{{ $article_info->category_id }}">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-10">
            <label>文章内容</label>
            <textarea id="article_content" class="form-control" placeholder="## 内容" style="min-height: 200px;">{{ $article_info->article_content }}</textarea>
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

            var article_id = '{{ $article_info->id }}';

            var _getTitle = function() {
                return document.getElementById('article_title').value;
            }

            var _getContent = function() {
                return document.getElementById('article_content').value;
            }

            var _getSign = function() {
                return document.getElementById('article_sign').value;
            }

            var _getCategoryId = function() {
                return document.getElementById('category_id_can_submit').value;
            }
            var _send = function(type) {
                var title = _getTitle();
                var content = _getContent();
                var sign = _getSign();
                var category_id = _getCategoryId;

                if(!title) {
                    alert('请填写标题');
                    return;
                }
                if(!content) {
                    alert('请填写内容');
                    return;
                }

                if(!category_id) {
                    alert("请选择最后的栏目分类");
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
                        article_id:article_id,
                        category_id:category_id
                    },
                    url:url,
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    success:function(d,s) {
                        if(d.res == 100) {
                            article_id = d.article_id;
                            alert('保存成功');
                            if(type == 'publish') {
                                location.href='{{ URL::to('admin/article/manage') }}';
                            }
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

            // 栏目工具（如果后期修改栏目怎么办呢？对于edit模板，要提前加载路径上所有节点）
            var _create = function(list,level) {
                var html = '';
                html += '<div class="btn-group" id="level_'+level+'" style="margin:5px;">';
                html += '<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">';
                html += '<span id="action_'+level+'">选择栏目</span><span class="caret"></span>';
                html += '</button>';
                html += '<ul class="dropdown-menu">';
                for(var i in list) {
                    html += '<li><a onclick="Editor.categoryTouch('+list[i].id+',\''+list[i].title+'\')">'+list[i].title+'</a></li>';
                }
                html += '</ul>';
                html += '</div>';

                return html;

            }
            var categoryTouch = function(category_id,category_title) {
                // 如果没有子节点，那么设置栏目隐藏域的值为节点id
                $.ajax({
                    type:'post',
                    data:{
                        'category_id':category_id
                    },
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    url:"{{ asset('admin/category/getNextLayerNodesByAjax') }}",
                    success:function(d,s) {
                        // 构造按钮组
                        if(d.res == 100) {
                            var html = _create(d.list, d.level);
                            var c_level = d.level -2;
                            var p_level = d.level -1;
                            // 将所有的大于当前被点击元素level的栏目remove掉
                            $("[id^=level_]:gt("+c_level+")").remove();
                            $("#level_"+ p_level).after(html);
                            // 内容生成
                            document.getElementById("action_"+ p_level).innerHTML = category_title;
                            // 如果不是list不是空俺么category_id的节点有子节点，不能进行提交
                            $("#category_id_can_submit").val('');
                        }else if(d.res == 101){
                            var c_level = d.level -2;
                            var p_level = d.level -1;
                            $("[id^=level_]:gt("+ c_level+")").remove();

                            document.getElementById("action_"+ p_level).innerHTML = category_title;
                            // 如果为空，那么将设置category_id为可以提交的叶子节点
                            $("#category_id_can_submit").val(category_id);
                        }else {
                            //
                        }
                    }
                })
            }

            return {
                draft:draft,
                publish:publish,
                categoryTouch:categoryTouch
            }
        }())
    </script>
@stop