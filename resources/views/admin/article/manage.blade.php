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
                            <button class="btn btn-sm btn-info">下架</button>
                        @elseif( $item->status=='draft' )
                            <button class="btn btn-sm btn-primary">发布</button>
                        @endif
                        <button class="btn btn-sm btn-success" onclick="window.location.href='{{ URL::to('admin/article/edit/'.$item->id)}}'">编辑</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@stop