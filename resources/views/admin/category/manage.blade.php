@extends('admin.main')
@section('right')
    <div class="row">
        <div class="col-md-6 form-inline">
            <input type="text" id="parent_title" class="form-control" placeholder="填写一级菜单名称">
            <button class="btn btn-info" onclick="Category.addParent()">确认添加</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
                @if ($category_list->count())
                    @foreach($category_list as $item)
                    <li class="list-group-item">
                        {{$item->title}}
                    </li>
                    @endforeach
                @else
                    <li class="list-group-item">
                        请添加父级栏目!!!
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <script>
        var Category = (function() {

            // 通用添加方法
            var _add = function(pid,title) {
                $.ajax({
                    type:'post',
                    data:{
                        'title':title,
                        'pid':pid
                    },
                    url:"{{ asset('admin/category/add') }}",
                    headers:{
                        'X-CSRF-TOKEN':"{{ csrf_token() }}"
                    },
                    success:function(d,s) {
                        if(d.res == 100) {
                            location.href='';
                        }else {
                            alert(d.msg);
                        }
                    }
                })
            }
            // 添加最外层一级节点
            var addParent = function() {
                var title = $("#parent_title").val();
                if(!title) {
                    alert("标题不能为空");
                    return;
                }

                _add('',title);
            }
            return {
                addParent:addParent
            }

        }())
    </script>
@stop