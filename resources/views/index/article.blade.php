@extends('index.body')
@section('body')
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <ol class="breadcrumb">
                @foreach ($parent_list as $item)
                    <li>{{ $item->title }}</li>
                @endforeach
            </ol>
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
    <div class="row">
        {{--<div class="col-md-8 col-md-offset-1">--}}
        {{--<!-- UY BEGIN -->--}}
        {{--<div id="uyan_frame"></div>--}}
        {{--<script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid=2138193"></script>--}}
        {{--<!-- UY END -->--}}
        {{--</div>--}}
        <div class="col-md-8 col-md-offset-1">
        <div id="disqus_thread"></div>
        <script>

            /**
             *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
             *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
            /*
             var disqus_config = function () {
             this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
             this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
             };
             */
            (function() { // DON'T EDIT BELOW THIS LINE
                var d = document, s = d.createElement('script');
                s.src = 'https://meng-da-na-xiao-zi.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        </div>
    </div>
@stop