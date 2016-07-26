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
        Auth::user();
//        $db  = new \PDO('mysql:host=localhost;dbname=laravel','root','');
//        $qres = $db -> query("show tables");
//        $r = $qres->fetchall();
//        var_dump($r);
        return view('index.index',[
                
        ]);
    }
}
