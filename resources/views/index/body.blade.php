@extends("common.main")
     @section("main_body")
     @include("index.navi")
         <div class="container-fluid">
            @yield('body')
         </div>
     @stop