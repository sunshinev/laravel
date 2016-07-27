<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    public function __construct() {

    }
    public function index() {
        
        return view('admin.index');   
    }
    public function articleAdd() {
        return view('admin.article.add');
    }
    public function articleManage() {
        return view('admin.article.manage');
    }
    public function classManage() {
        return view('admin.class.manage');
    }
}
