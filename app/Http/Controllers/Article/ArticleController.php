<?php

namespace App\Http\Controllers\Article;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    public function draft(Request $request) {

        $param['article_title'] = $request->input('article_title');
        $param['article_content'] = $request->input('article_content');
        $param['article_sign'] = $request->input('article_sign');


    }
}
