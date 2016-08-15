@extends("index.body")
@section("body")
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <ol class="breadcrumb">
                <li>搜索栏目</li>
                @foreach ($parent_list as $item)
                    <li>{{ $item->title }}</li>
                @endforeach
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1" >
            @if (count($article_list))
            @foreach ($article_list as $key=>$item)
                <div class="row">
                    <div class="col-md-12">
                        <h3><a href="{{ URL::to('article/'.$item->id) }}">#{{ $item->article_title }}</a></h3>
                        <div>
                            @foreach($item->article_sign as $sign)
                                <kbd>{{ $sign }}</kbd>
                            @endforeach
                        </div>
                        <small>更新于{{ $item->updated_at }}</small>
                    </div>
                </div>
            @endforeach
            @else
                <div class="jumbotron">
                    <h1>^^</h1>
                    <p>没有更多记录，小编后期会补充的啦~</p>
                    <p><a class="btn btn-success btn-sm" href="#" role="button" onclick="history.back()">返回上一页</a></p>
                </div>
            @endif
        </div>
    </div>
@stop