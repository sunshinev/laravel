<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //

    public function index() {

        $articles = Article::all();
        var_dump($articles);
    }

    public function store() {
        $article = new Article;
        $article -> article_title = '1';
        $article -> article_content = '1';
        $article -> article_sign = '1';
        $article -> save();
    }
}
