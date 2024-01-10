<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColorGameController extends Controller
{
    public function color(){
        return view('colorgame.colorgame-v2');
    }
}