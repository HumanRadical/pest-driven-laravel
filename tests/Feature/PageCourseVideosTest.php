<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\get;

it('cannot be accessed by guest', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    // Act & Assert
    get(route('pages.course-videos', $course))
        ->assertRedirect(route('login'));
});

it('includes video player', function () {
    // Arrange
    loginAsUser();
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    // Act & Assert
    get(route('pages.course-videos', $course))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);
});

it('shows first course video by default', function () {
    // Arrange
    loginAsUser();
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    // Act & Assert
    get(route('pages.course-videos', $course))
        ->assertOk()
        ->assertSeeText($course->videos()->first()->title);
});

it('shows provided course video', function () {
    // Arrange
    loginAsUser();
    $course = Course::factory()
        ->has(Video::factory(2)->state(
            new Sequence(
                ['title' => 'First Video'],
                ['title' => 'Second Video'],
            )))
        ->create();

    // Act & Assert
    get(route('pages.course-videos', [
        'course' => $course,
        'video' => $course->videos()->orderByDesc('id')->first(),
    ]))
        ->assertOk()
        ->assertSeeText('Second Video');
});
