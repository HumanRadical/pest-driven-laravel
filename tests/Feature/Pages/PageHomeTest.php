<?php

use App\Models\Course;
use Carbon\Carbon;

use function Pest\Laravel\get;

it('shows courses overview', function () {
    // Arrange
    $courses = Course::factory(3)->released()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
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
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText($releasedCourse->title)
        ->assertDontSeeText($unreleasedCourse->title);
});

it('shows courses by release date', function () {
    // Arrange
    $oldCourse = Course::factory()->released(Carbon::yesterday())->create();
    $newCourse = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeTextInOrder([
            $newCourse->title,
            $oldCourse->title,
        ]);
});

it('includes login if not logged in', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Login')
        ->assertSee(route('login'));
});

it('includes logout if logged in', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Logout')
        ->assertSee(route('logout'));
});
