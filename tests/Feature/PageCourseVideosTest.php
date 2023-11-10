<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;

use function Pest\Laravel\get;

it('cannot be accessed by guest', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    get(route('pages.course-videos', $course))
        ->assertRedirect(route('login'));
});

it('includes video player', function () {
    // Arrange
    loginAsUser();
    $course = Course::factory()->create();

    // Act & Assert
    get(route('pages.course-videos', $course))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);
});

it('shows first course video by default', function () {
    // Arrange
    loginAsUser();
    $course = Course::factory()
        ->has(Video::factory()->state(['title' => 'My Video']))
        ->create();

    // Act & Assert
    get(route('pages.course-videos', $course))
        ->assertOk()
        ->assertSeeText('My Video');
});

it('shows provided course video', function () {
    //expect()->
});
