<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    
    public function __construct(){


    }

    public function index(Request $request){
    	echo "222";
    }
}
