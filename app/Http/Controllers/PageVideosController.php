<?php

namespace App\Http\Controllers;

use App\Models\Course;

class PageVideosController extends Controller
{
    public function __invoke(Course $course)
    {
        $video = $course->videos->first();

        return view('pages.course-videos', compact('video'));
    }
}
