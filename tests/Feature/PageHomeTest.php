<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', function () {
    $this->withoutExceptionHandling();

    Course::factory()->create(['title' => 'Course A', 'description' => 'Description Course A']);
    Course::factory()->create(['title' => 'Course B', 'description' => 'Description Course B']);
    Course::factory()->create(['title' => 'Course C', 'description' => 'Description Course C']);

    get(route('home'))
        ->assertSeeText([
            'Course A',
            'Description Course A',
            'Course B',
            'Description Course B',
            'Course C',
            'Description Course C',
        ]);
});

it('shows only released courses', function () {
    //expect()->
});

it('shows courses by release date', function () {
    //expect()->
});