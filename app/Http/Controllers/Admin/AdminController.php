<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;

class AdminController extends Controller
{
    public function __construct() {

    }
    /*
     * 后台首页
     */
    public function index() {
        return view('admin.index');   
    }
    /*
     * 添加文章
     */
    public function articleAdd(Request $request) {

        return view('admin.article.add');
    }
    /*
     * 文章编辑
     */
    public function articleEdit(Request $request) {
        $article_id = $request->article_id;
        $article_info = Article::where('id',$article_id)->first();
        return view('admin.article.edit',['article_info'=>$article_info,'article_id'=>$article_id]);

    }
    /*
     * 文章列表管理
     */
    public function articleManage() {

        $list = Article::orderBy('updated_at','desc')->get();

        return view('admin.article.manage',['article_list'=>$list]);
    }
    public function classManage() {
        return view('admin.class.manage');
    }
}
