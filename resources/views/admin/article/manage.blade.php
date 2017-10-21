@extends('admin.main')
@section('right')
    <div class="row">
        <table class="table">
            <tr>
                <th>#</th>
                <th>标题</th>
                <th>最后更新时间</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            @foreach ($article_list as $id =>$item)
                <tr>
                    <td></td>
                    <td>{{$item->article_title}}</td>
                    <td>{{$item->updated_at}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>
                        @if( $item->status=='publish' )
                            <button class="btn btn-sm btn-info" onclick="Editor.draft('{{ $item->article_id }}')">下架</button>
                        @else
                            <button class="btn btn-sm btn-primary" onclick="Editor.publish('{{ $item->article_id }}')">发布</button>
                        @endif
                        <button class="btn btn-sm btn-success" onclick="window.location.href='{{ URL::to('admin/article/edit/'.$item->id)}}'">编辑</button>
                            <button class="btn btn-sm btn-danger" onclick="Editor.remove('{{$item->article_id}}')">删除</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <script>
        var Editor = (function() {
            var draft = function(article_id) {
                _setStatus(article_id,'draft');
            }

            var publish = function(article_id) {
                _setStatus(article_id,'publish');
            }
            var remove = function(article_id) {
                _setStatus(article_id,'remove');
            }

            var _setStatus = function(article_id,status) {
                if(!article_id) {
                    alert('article_id is error');
                    return;
                }
                $.ajax({
                    type:'post',
                    url:'{{ asset('admin/article/set_status') }}',
                    data:{article_id:article_id,status:status},
                    headers:{
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    success:function(d,s) {
                        if(d.res !=100) {
                            alert(d.msg);
                        }else {
                            window.location.href='';
                        }
                    }
                })
            }

            return {
                draft:draft,
                publish:publish,
                remove:remove
            }
        }())
    </script>
@stop