<?php

use App\Models\Course;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows course details', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    get(route('course-details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->tagline,
            $course->description,
            ...$course->learnings,
        ])
        ->assertSee(asset("images/{$course->image}"));
});

it('shows course video count', function () {
    // Arrange
    $course = Course::factory()->create();
    Video::factory(3)->create(['course_id' => $course->id]);

    // Act & Arrange
    get(route('course-details', $course))
        ->assertOk()
        ->assertSeeText('3 videos');
});
