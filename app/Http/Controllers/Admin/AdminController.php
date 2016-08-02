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
            'root_list'=>$list,
            'category_list'=>null,
            'root_node'=>null,
            'current_node'=>null,
        ]);
    }

    /*
     * 接受参数处理分类展示
     */
    public function categoryManageWithParams(Request $request) {

        // 根据提供的倒数第二级别父节点的ID，来生成列表地图
        $node_id = $request->pid;

        // 加载节点信息
        $node_info  = Category::where('id',$node_id)->first();

        // 加载分支路径
        $parent_list = Category::where('right_val','>=',$node_info->right_val)
            ->where('left_val','<=',$node_info->left_val)
            ->orderBy('left_val','asc')
            ->get();

        // 根据最外层的节点来加载整个分支树，最大层限制为当前child的层级
        $root_node = $parent_list[0];

        // 该分支列表
        $branch_list = Category::where('level','<=',$node_info->level)
            ->where('right_val','<',$root_node->right_val)
            ->where('left_val','>',$root_node->left_val)
            ->get();
        // 获取当前点击对象的，下层子节点
        $child_list = Category::where('level','<=',$node_info->level+1)
            ->where('right_val','<',$node_info->right_val)
            ->where('left_val','>',$node_info->left_val)
            ->get();

        // 构造分支路径新数组，按照level和id分级
        $parent_list_new = [];
        foreach($parent_list as $key=>$item) {
            $parent_list_new[$item->level][$item->id] = $item;
        }

        // 遍历分支构造，按照level进行分支
        $branch_list_new = [];
        foreach($branch_list as $key=>$item) {
            if(isset($parent_list_new[$item->level][$item->id])) {
                // 标记分支节点 ，此处需要在模型里添加修改器
                $item->is_current = true;
            }
            $branch_list_new[$item->level][$item->id] = $item;
        }
        // 将子节点进行遍历加入map
        foreach($child_list as $item) {
            $branch_list_new[$item->level][$item->id] = $item;
        }

        // 加载根路径列表
        $root_list = Category::where('level',1)->get();

        return view('admin.category.manage',['root_list'=>$root_list,'category_list'=>$branch_list_new,'root_node'=>$root_node,'current_node'=>$node_info]);






    }

}
