<?php

use App\Models\Course;
use App\Models\Video;

it('only returns released courses for released scope', function () {
    // Arrange
    Course::factory()->released()->create();
    Course::factory()->create();

    // Act & Assert
    expect(Course::released()->get())
        ->toHaveCount(1)
        ->first()->id->toEqual(1);
});

it('has videos', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory(3))
        ->create();

    // Act & Assert
    expect($course->videos)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Video::class);
});
