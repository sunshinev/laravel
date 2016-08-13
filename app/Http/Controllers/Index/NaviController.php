<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * 用于控制导航的递归生成
 * Class NaviController
 * @package App\Http\Controllers\Index
 */
class NaviController extends Controller
{
    /**
     *
     */
    public static function createNavi($list) {
        $html = '';
        foreach($list as $item) {
            $html .= '<li class="dropdown">';
            if($item['list']) {
                $html .= '<a tabindex="0" data-toggle="dropdown" data-submenu="">';
                $html .= $item->title;
                $html .= '<span class="caret"></span>';
                $html .= '</a>';
            }else {
                $html .= '<a tabindex="0" href="'.action('Index\IndexController@searchArticle',$item->id).'">';
                $html .= $item->title;
                $html .= '</a>';
            }
            $html .= self::createSubNavi($item);
            $html .= '</li>';
        }
        return $html;
    }

    /**
     * 递归生成
     * @param $node
     * @return string
     */
    private static  function createSubNavi($node) {
        $html = '';
        $html .= '<ul class="dropdown-menu">';
        foreach($node['list'] as $item) {
            // 如果没有子树，那么不加载箭头样式
            if($item['list']) {
                $html .= '<li class="dropdown-submenu">';
                $html .= '<a tabindex="0">'.$item->title.'</a>';
            }else {
                $html .= '<li>';
                $html .= '<a tabindex="0" href="'.action('Index\IndexController@searchArticle',$item->id).'">'.$item->title.'</a>';
            }

            $html .= self::createSubNavi($item);
            $html .= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }
}
