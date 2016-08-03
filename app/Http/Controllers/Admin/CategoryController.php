<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Category;

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
        Category::where('right_val','>=',$p_info->right_val)
            ->increment('right_val',2);

        // 插入新的子节点
        $child_node = new Category();
        $child_node->right_val = $p_info->right_val + 1;
        $child_node->left_val = $p_info->right_val;
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


}
