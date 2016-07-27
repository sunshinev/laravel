@extends('common.main')

@section('body')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form action="{{ action("Auth\AuthController@postLogin")}}" method="post">
            <label>邮箱</label>
            <input type="eamil" name="email" value="{{ old('email') }}" class="form-control">
            <label>密码</label>
            <input type="password" name="password" class="form-control">
            <div>
                <input type="checkbox" name="remember"> 记住我
            </div>
            <br>
            <input type="submit" name="submit" class="btn btn-success form-control" value="submit">
            {{ csrf_field() }}
            </form>
        </div>
    </div>
@show