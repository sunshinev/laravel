<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Article;
use App\Category;

class ArticleController extends Controller
{
    /**
     * 保存通用方法
     * 内部区分第一次保存，还是自动保存
     * */
    public function save($request) {
        $article_title = $request->input('article_title');
        $article_content = $request->input('article_content');
        $article_sign = trim($request->input('article_sign'));
        $article_id = trim($request->input('article_id'));
        $category_id = $request->input('category_id');

        if(count(explode(' ',$article_sign)) > 5) {
            return ['res'=>101,'msg'=>'标签数量不能大于5个'];
        }
        if(!$category_id) {
            return ['res'=>101,'msg'=>'请选择栏目'];
        }
        // 获取栏目的节点信息，判断左右值是否是相差1
        $category_info = Category::where('id',$category_id)->first();
        if($category_info->right_val-$category_info->left_val != 1) {
            return ['res'=>101,'msg'=>'您选择的栏目不是叶子节点'];
        }
        // save
        if(Article::where('id',$article_id)->first()) {
            $r = Article::where('id',$article_id)
                ->update([
                    'article_title'=>$article_title,
                    'article_content'=>$article_content,
                    'article_sign'=>$article_sign,
                    'category_id'=>$category_id

                ]);
            return ['res'=>100,'msg'=>'成功','article_id'=>$article_id];

        }else {
            $article = new Article();
            $article -> article_title = $article_title;
            $article -> article_content = $article_content;
            $article -> article_sign = $article_sign;
            $article -> category_id = $category_id;
            $article -> status = 'draft';

            if(!$article -> save()) {
                return ['res'=>101,'msg'=>'保存草稿失败'];
            }
            return ['res'=>100,'msg'=>'成功','article_id'=>$article->id];
        }
    }
    /**
     * 保存为草稿
    */
    public function draft(Request $request)
    {
        return response()->json($this->save($request));
    }

    /**
     * 保存并发布，先保存成功后，在调用publish修改状态为发布
     *
    */
    public function publish(Request $request) {
        $r = $this->save($request);

        if($r['res'] == 100) {
            $article_id = $r['article_id'];
            $r = Article::where('id',$article_id)
                ->update(['status'=>'publish']);
            return response()->json(['res'=>100,'msg'=>'成功','article_id'=>$article_id]);
        }else {
            return response()->json($r);
        }
    }

    /**
     * 设置文章的状态
     */
    public function setStatus(Request $request) {
        $article_id = $request->input('article_id');
        $status = $request->input('status');
        switch($status) {
            case 'publish':
            case 'draft':
                break;
            default:
                return response()->json([
                    'res'=>101,
                    'msg'=>'类型错误'
                ]);
        }
        // 写入状态
        $r = Article::where('id',$article_id)
            ->update(['status'=>$status]);
        return response()->json([
            'res'=>100,
            'msg'=>'success'
        ]);
    }
}
