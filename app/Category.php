<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'categories';
    /*
     * 用来标记是否是当前分支节点
     */
    public function setIsCurrentAttribute($value) {

        $this->attributes['is_current'] = $value;
    }
}
