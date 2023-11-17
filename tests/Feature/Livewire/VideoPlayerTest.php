<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;
use Livewire\Livewire;

it('shows details for given video', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()->state([
            'title' => 'Video title',
            'description' => 'Video description',
            'duration' => 10,
        ]))->create();

    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video' => $course->videos->first()])
        ->assertSeeText([
            'Video title',
            'Video description',
            '10min',
        ]);
});

it('shows given video', function () {
    //expect()->
});