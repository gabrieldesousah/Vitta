<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VittalecasController extends Controller
{
    public function oquesao(){
    	return view("vittalecas.oquesao");
    }

    public function regulamento(){
    	return view("vittalecas.regulamento");
    }
}
