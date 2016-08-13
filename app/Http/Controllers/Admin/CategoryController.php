<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Category;
use App\Article;

class CategoryController extends Controller
{
   /*
    * 添加节点
    * 支持父类、子类、平级类
    */
    function insertNode(Request $request) {
        $pid = $request->pid;
        $title = $request->title;


        if(!$pid) {
            $r = $this->addFirstLevel($title);
        }else {
            $r =$this->addChildNode($pid,$title);
        }

        if($r) {
            return response()->json(['res'=>100,'msg'=>'success']);
        }else {
            return response()->json(['res'=>101,'msg'=>'添加栏目失败']);
        }
    }

    /*
     * 添加父级节点
     */

    function addFirstLevel($title) {

        //  读取level=1的节点的数据，获取最右节点
        $pre_node = Category::where('level',1)
            ->orderBy('left_val','desc')
            ->first();

        $right_val_max = count($pre_node) ? $pre_node->right_val : 0;

        $left_val = $right_val_max + 1;
        $right_val = $left_val + 1;


        // 得到新增父级节点的左右值
        $category  = new Category();
        $category->left_val = $left_val;
        $category->right_val = $right_val;
        // 新增父级节点默认等级是1
        $category->level = 1;
        $category->title = $title;

        return  $category->save();
    }

    /*
     * 添加子节点
     */
    function addChildNode($pid,$title) {
        // 查询当前父级节点的信息
        $p_info = Category::where('id',$pid)->first();

        // 更新所有大于等于父级节点的right_val的节点的right_val = right_val+2
        Category::where('right_val','>',$p_info->right_val)
            ->increment('right_val',2);
        // 更新左值
        Category::where('left_val','>',$p_info->right_val)
            ->increment('left_val',2);

        // 更新自己的节点值
        Category::where('id',$pid)->increment('right_val',2);
        // 插入新的子节点
        $child_node = new Category();
        $child_node->left_val = $p_info->right_val;
        $child_node->right_val = $p_info->right_val+1;
        $child_node->level = $p_info->level + 1;
        $child_node->title = $title;
        return $child_node->save();

    }

    /*
     * 获取某一节点下的，下一层节点集合
     */
    function getNextLayerNodes($pid) {
        // 查询当前父级节点的信息
        $p_info = Category::where('id',$pid)->first();

        $list = Category::where('left_val','>',$p_info->left_val)
            ->where('right_val','<',$p_info->right_val)
            ->where('level','=',$p_info->level+1)
            ->get();

        return $list;
    }
    /*
     *
     */
    function getNextLayerNodesByAjax(Request $request) {
        $pid = $request->category_id;

        $p_info = Category::where('id',$pid)->first();

        $list = $this->getNextLayerNodes($pid);
        if($list->count()) {
            return response()->json(['res'=>100,'msg'=>'success','list'=>$list,'level'=>$p_info->level+1]);
        }
        return response()->json(['res'=>101,'msg'=>'empty','list'=>null,'level'=>$p_info->level+1]);
    }

    /*
     * 更新节点内容
     */
    function updateNode(Request $request) {
        $category_id = $request->category_id;
        $category_title = $request->title;

        if(!$category_title) {
            return response()->json(['res'=>101,'msg'=>'标题不能为空']);
        }

        $res = Category::where('id',$category_id)
            ->update([
                'title'=>$category_title
            ]);

        if($res) {
            return response()->json(['res'=>100,'msg'=>'success']);
        }
        return response()->json(['res'=>101,'msg'=>'有错误']);
    }

    /**
     * 移除节点
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeNode(Request $request) {
        $category_id = $request->category_id;
        if(!$category_id) {
            return response()->json(['res'=>'101','msg'=>'id为空']);
        }
        // 查询当前节点信息
        $node_info = Category::where('id',$category_id)->first();

        if(!count($node_info)) {
            return response()->json(['res'=>'101','msg'=>'node is not exists']);
        }
        // 查询是否还有子节点，如果有子节点禁止删除
        if($node_info->right_val - $node_info->left_val > 1) {
            return response()->json(['res'=>'101','msg'=>'请先移除子节点']);
        }
        // 查询是否有关联该节点的文章
        $is_article_node = Article::where('category_id',$category_id)->count();
        if($is_article_node) {
            return response()->json(['res'=>'101','msg'=>'改栏目下有文章关联，请先修改文章栏目']);
        }

        // 查询父节点的信息
        $parent_node = Category::where('right_val','>',$node_info->right_val)
            ->where('left_val','<',$node_info->left_val)
            ->where('level','=',$node_info->level - 1)
            ->first();

        // 允许移除，直接从表中删除数据，任何在表中的左右值数据，都可能会影响使用
        // 修改右值大于该节点右值的所有节点的右值-2
        Category::where('right_val','>',$node_info->right_val)
            ->decrement('right_val',2);
        // 修改左值大于该节点右值得所有节点的左值-2
        Category::where('left_val','>',$node_info->right_val)
            ->decrement('left_val',2);
        // 直接删除该节点
        Category::where('id',$category_id)->delete();

        // 添加pid方便删除节点之后，直接跳转到父级目录的页面，避免报错
        return response()->json(['res'=>'100','msg'=>'success','pid'=>$parent_node->id]);


    }


}
