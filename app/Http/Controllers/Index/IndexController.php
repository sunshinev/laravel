<?php
namespace App\Http\Controllers\Index;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function index() {
        return view('index.index',[
                
        ]);
    }
}
