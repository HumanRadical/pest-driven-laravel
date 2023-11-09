<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageDashboardController extends Controller
{
    public function __invoke()
    {
        $purchasedCourses = auth()->user()->courses;

        return view('dashboard', compact('purchasedCourses'));
    }
}
