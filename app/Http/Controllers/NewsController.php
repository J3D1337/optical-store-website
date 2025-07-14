<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
public function newsView(){
    // $news = News::latest()->get();
    // return view('news', compact('news'));
}
}
