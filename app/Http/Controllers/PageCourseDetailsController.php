<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageCourseDetailsController extends Controller
{
    public function __invoke()
    {
        return view('course-details');
    }
}
