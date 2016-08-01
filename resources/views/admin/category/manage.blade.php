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
                    <li class="list-group-item" onclick="Category.dropDown('{{ $item->id }}')">
                        {{$item->title}}
                    </li>
                    <li class="list-group-item" style="display:none" id="dropdown_{{ $item->id }}">
                        <button class="btn btn-sm btn-info"><span class="glyphicon glyphicon-plus"></span></button>
                        <button class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-remove"></span></button>
                        <button class="btn btn-sm btn-success"><span class="glyphicon glyphicon-pushpin"></span></button>
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


            // 点击触发下拉工具条
            var dropDown = function(id) {
                $("[id^=dropdown_]").slideUp('fast');
                $("#dropdown_"+id).slideToggle();
            }
            return {
                addParent:addParent,
                dropDown:dropDown
            }

        }())
    </script>
@stop