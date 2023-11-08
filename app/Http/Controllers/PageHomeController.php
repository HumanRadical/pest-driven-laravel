<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class PageHomeController extends Controller
{
    public function __invoke()
    {
        $courses = Course::all();
        
        return view('home', compact('courses'));
    }
}
