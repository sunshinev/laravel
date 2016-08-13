@extends('common.navi')
@section('navi_body')
        <!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="#">Brand</a>
</div>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <ul class="nav navbar-nav">
    <?php echo $navi; ?>
  </ul>
  <form class="navbar-form navbar-left" role="search">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
  <ul class="nav navbar-nav navbar-right">
    @if (Auth::user())
      <li><a href="{{ url('auth/logout') }}">退出</a></li>
    @else
      <li><a href="{{ url('auth/login') }}">登陆</a></li>
      <li><a href="{{ url('auth/register') }}">注册</a></li>
    @endif
  </ul>
</div><!-- /.navbar-collapse -->
<script>
  $('[data-submenu]').submenupicker();
</script>
@stop