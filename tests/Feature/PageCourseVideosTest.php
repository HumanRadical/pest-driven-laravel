<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;

use function Pest\Laravel\get;

it('cannot be accessed by guest', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    get(route('page.course-videos', $course))
        ->assertRedirect(route('login'));
});

it('includes video player', function () {
    // Arrange
    loginAsUser();
    $course = Course::factory()->create();

    // Act & Assert
    get(route('page.course-videos', $course))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);
});

it('shows first course video by default', function () {
    //expect()->
});

it('shows provided course video', function () {
    //expect()->
});
