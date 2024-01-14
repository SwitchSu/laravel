<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColorGameController extends Controller
{
    public function color(){
        // $news = DB::table('news')->get();
        //$news = News::get();
        //dump and die
        // dd($news);
        return view('colorgame.colorgame-v2');
    }
}

