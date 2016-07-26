@if (count($errors->all()) > 0)
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        {{$error}}
    </div>
    @endforeach
    <script>
    $(function() {
        var intv = setInterval(function() {
            $('.alert').slideUp('slow',function() {
                $(this).remove();
                });
            },3000)
    })
    </script>
@endif