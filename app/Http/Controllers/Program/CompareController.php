<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index(){
        return view('programs.compare.index');
    }

    public function compare(Request $request){
        
    }
}
