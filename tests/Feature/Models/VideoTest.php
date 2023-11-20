<?php

use App\Models\Course;
use App\Models\Video;

it('gives back readable video duration', function () {
    // Arrange
    $video = Video::factory()->create(['durationInMins' => 10]);

    // Act & Arrange
    expect($video->getReadableDuration())->toEqual('10min');
});

it('has courses', function () {
    // Arrange
    $video = Video::factory()
        ->has(Course::factory())
        ->create();

    // Act & Assert
    expect($video->course)->toBeInstanceOf(Course::class);
});
