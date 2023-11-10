<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Video;

class PageVideosController extends Controller
{
    public function __invoke(Course $course, Video $video = null)
    {
        $video = $video ?? $course->videos->first();

        return view('pages.course-videos', compact('video'));
    }
}
