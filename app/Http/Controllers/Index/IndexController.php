<?php
namespace App\Http\Controllers\Index;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;
use App\Http\Controllers\HyperDownController;
use App\Category;

class IndexController extends Controller
{
    /*
     * 首页
     */
    public function index() {
        // 加载列表
        $article_list = Article::where('status','publish')
            ->orderBy('created_at','desc')->get();
        // 重载标签
        foreach($article_list as &$item) {
            $item->article_sign = explode(' ',$item->article_sign);
        }
        return view('index.index',[
                'article_list'=>$article_list
        ]);
    }
    /*
     * 内容详情页
     */
    public function article(Request $request) {
        $article_id = $request->article_id;
        $article_info = Article::where('id',$article_id)
            ->where('status','=','publish')
            ->first();
        if(!count($article_info)) {
            abort(404);
        }
        $article_info->article_sign = explode(' ',$article_info->article_sign);
        $hyper_parse = new HyperDownController();
        $article_info->article_content = $hyper_parse->makeHtml($article_info->article_content);

        // 加载分支路径节点
        $node_info = Category::where('id',$article_info->category_id)->first();

        $parent_list = Category::where('right_val','>=',$node_info->right_val)
            ->where('left_val','<=',$node_info->left_val)
            ->orderBy('left_val','asc')
            ->get();

        return view('index.article',[
            'article_info'=>$article_info,
            'parent_list'=>$parent_list

        ]);
    }

    /**
     * 栏目文章列表搜索
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchArticle(Request $request) {
        $category_id = $request->category_id;
        // 面包屑生成
        $node_info = Category::where('id',$category_id)
            ->first();

        $parent_list = Category::where('right_val','>=',$node_info->right_val)
            ->where('left_val','<=',$node_info->left_val)
            ->orderBy('left_val','asc')
            ->get();
        // 加载栏目关联的文章列表
        $list = Article::where('category_id',$category_id)
            ->where('status','=','publish')
            ->orderBy('updated_at','desc')
            ->get();

        // 重载标签
        foreach($list as &$item) {
            $item->article_sign = explode(' ',$item->article_sign);
        }

        return view('index.list',[
            'article_list'=>$list,
            'parent_list'=>$parent_list
        ]);
    }

    /**
     * 搜索结果列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request) {
        $keywords = $request->keywords;
        $list = null;
        if(!$keywords) {
            // list empty
        }else {
            $list = Article::where('article_title','like',"%$keywords%")
                ->where('status','=','publish')
                ->orWhere('article_content','like',"%$keywords%")
                ->get();
        }

        return view('index.search',[
            'article_list'=>$list,
            'keywords'=>$keywords,
            'count'=>count($list)
        ]);
    }
}
