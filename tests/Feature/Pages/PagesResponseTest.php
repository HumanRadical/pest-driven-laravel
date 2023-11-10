<?php

use App\Models\Course;

use function Pest\Laravel\get;

it('returns a successful response for home page', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk();
});

it('returns a successful response for course details page', function () {
    //Arrange
    $course = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk();
});

it('returns a successful response for dashboard page', function () {
    //Arrange
    loginAsUser();

    // Act & Assert
    get(route('pages.dashboard'))
        ->assertOk();
});
