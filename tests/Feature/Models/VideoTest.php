<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Video;

it('gives back readable video duration', function () {
    // Arrange
    $video = Video::factory()->create(['duration_in_mins' => 10]);

    // Act & Arrange
    expect($video->getReadableDuration())->toEqual('10min');
});

it('belongs to a course', function () {
    // Arrange
    $video = Video::factory()
        ->has(Course::factory())
        ->create();

    // Act & Assert
    expect($video->course)->toBeInstanceOf(Course::class);
});

it('tells if current user has not yet watched a given video', function () {
    // Arrange
    loginAsUser();
    $video = Video::factory()->create();

    // Act & Assert
    expect($video->alreadyWatchedByCurrentUser())->toBeFalse();
});

it('tells if current user has already watched a given video', function () {
    // Arrange
    $user = loginAsUser(
        User::factory()
            ->has(Video::factory(), 'watchedVideos')
            ->create()
    );
    $video = Video::factory()->create();

    // Act & Assert
    expect($user->watchedVideos()->first()->alreadyWatchedByCurrentUser())->toBeTrue();
});
