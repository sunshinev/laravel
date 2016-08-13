<?php

namespace App\Http\Middleware;

use Closure;
use App\Category;
use App\Http\Controllers\Index\NaviController;

class NaviMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 加载所有的导航目录结构树
        $list = Category::all();
        // 按照level进行分类
        $level_list = [];
        foreach($list as $value) {
            $level_list[$value['level']][] = $value;
        }
        // 遍历每一级level找到下一级别的子集
        $new_list = $level_list[1];
        foreach($new_list as &$item) {
            // 叶子节点跳过查询
            $item['list'] = $this->findSubLevel($item,$list);
        }

        // 创建html导航内容
        $navi = NaviController::createNavi($new_list);
        view()->share('navi',$navi);
        return $next($request);
    }

    /**
     * 递归查询树结构
     * @param $node
     * @param $list
     * @return array
     */
    private function findSubLevel($node,$list) {
        $new_list = [];
        foreach($list as $item) {
            if($item->right_val < $node->right_val && $item->left_val > $node->left_val && $item->level == $node->level + 1) {
                $new_list[] = $item;
            }
        }
        foreach($new_list as $key=>$item) {
            $new_list[$key]['list'] = $this->findSubLevel($item,$list);
        }
        return $new_list;
    }
}
