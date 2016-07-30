@extends("index.body")
@section("body")
    <div class="row">
        <div class="col-md-10 col-md-offset-1" >
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
        </div>
    </div>
@stop