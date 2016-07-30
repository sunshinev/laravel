@extends('index.body')
@section('body')
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <h3>{{ $article_info->article_title }}</h3>
            <div>
                @foreach ($article_info->article_sign as $sign)
                    <kbd>{{ $sign }}</kbd>
                @endforeach
            </div>
            <small>更新于{{ $article_info->updated_at }}</small>
            <p><?php echo $article_info->article_content?></p>
        </div>
    </div>
@stop