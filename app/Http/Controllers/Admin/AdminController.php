<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;
use App\Http\Controllers\Admin\CategoryController;

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
    /*
     * 分类管理模板加载，预加载父类
     * 或者可以通过ajax加载父类
     */
    public function categoryManage(Request $request) {

        $list = Category::where('level',1)->get();

        return view('admin.category.manage',[
            'category_list'=>$list
        ]);
    }
}
