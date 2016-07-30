@extends("common.main")
     @section("main_body")
     @include("index.navi")
         <div class="container-fluid" style="margin-top:100px;">
            @yield('body')
         </div>
     @stop