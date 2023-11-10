<?php

namespace App\Http\Controllers;

class PageVideosController extends Controller
{
    public function __invoke()
    {
        return view('pages.course-videos');
    }
}
