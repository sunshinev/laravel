<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;

class AdminController extends Controller
{
    //
    public function __construct() {

    }
    public function index() {
        return view('admin.index');   
    }
    public function articleAdd() {
        return view('admin.article.add');
    }
    public function articleManage() {

        $list = Article::orderBy('updated_at','desc')->get();
        foreach($list as $item) {
            var_dump($item->created_at);
        }

        //return view('admin.article.manage');
    }
    public function classManage() {
        return view('admin.class.manage');
    }
}
