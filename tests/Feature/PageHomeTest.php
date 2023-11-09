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
    Course::factory()->create(['title' => 'Course A', 'released_at' => Carbon::yesterday()]);
    Course::factory()->create(['title' => 'Course B']);

    // Act & Assert
    get(route('home'))
        ->assertSeeText('Course A')
        ->assertDontSeeText('Course B');
});

it('shows courses by release date', function () {
    // Arrange
    Course::factory()->create(['title' => 'Course A', 'released_at' => Carbon::yesterday()]);
    Course::factory()->create(['title' => 'Course B', 'released_at' => Carbon::now()]);

    // Act & Assert
    get(route('home'))
        ->assertSeeTextInOrder([
            'Course B',
            'Course A',
        ]);
});