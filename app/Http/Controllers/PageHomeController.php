<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class PageHomeController extends Controller
{
    public function __invoke()
    {
        $courses = Course::query()
            ->released()
            ->orderBy('released_at', 'desc')
            ->get();

        return view('home', compact('courses'));
    }
}
