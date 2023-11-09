<?php

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', function () {
    // Arrange
    $courses = Course::factory(3)->released()->create();

    // Act & Assert
    get(route('home'))
        ->assertSeeText([
            ...$courses->pluck('title')->toArray(),
            ...$courses->pluck('description')->toArray(),
        ]);
});

it('shows only released courses', function () {
    // Arrange
    $releasedCourse = Course::factory()->released()->create();
    $unreleasedCourse = Course::factory()->create();

    // Act & Assert
    get(route('home'))
        ->assertSeeText($releasedCourse->title)
        ->assertDontSeeText($unreleasedCourse->title);
});

it('shows courses by release date', function () {
    // Arrange
    $oldCourse = Course::factory()->released(Carbon::yesterday())->create();
    $newCourse = Course::factory()->released()->create();

    // Act & Assert
    get(route('home'))
        ->assertSeeTextInOrder([
            $newCourse->title,
            $oldCourse->title,
        ]);
});
