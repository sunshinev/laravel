@extends('common.main')
<div class="container">
@include('auth.navi')
@section('main_body')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form action="{{ action("Auth\AuthController@postRegister")}}" method="post">
            <label>姓名</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
            <label>邮箱</label>
            <input type="eamil" name="email" value="{{ old('email') }}" class="form-control">
            <label>密码</label>
            <input type="password" name="password"  class="form-control">
            <label>再次确认密码</label>
            <input type="password" name="password_confirmation"  class="form-control">
            <br>
            <input type="submit" name="submit" class="btn btn-success form-control" value="submit">
            {{ csrf_field() }}
            </form>
             @include('errors.errors')
        </div>
    </div>
@stop
</div>

