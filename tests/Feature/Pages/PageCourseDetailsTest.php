<?php

use App\Models\Course;
use App\Models\Video;
use Juampi92\TestSEO\TestSEO;

use function Pest\Laravel\get;

it('does not show details for unreleased course', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertNotFound();
});

it('shows course details', function () {
    // Arrange
    $course = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->tagline,
            $course->description,
            ...$course->learnings,
        ])
        ->assertSee(asset("images/{$course->image}"));
});

it('shows course video count', function () {
    // Arrange
    $course = Course::factory()
        ->released()
        ->has(Video::factory(3))
        ->create();

    // Act & Arrange
    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText('3 videos');
});

it('includes paddle checkout button', function () {
    // Arrange
    config()->set('services.paddle.vendor-id', 'vendor-id');
    $course = Course::factory()
        ->released()
        ->create([
            'paddle_product_id' => 'product-id',
        ]);

    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSee('<script src="https://cdn.paddle.com/paddle/paddle.js"></script>', false)
        ->assertSee('Paddle.Setup({ vendor: vendor-id })', false)
        ->assertSee('<a href="#!" class="paddle_button" data-product="product-id">Buy Now!</a>', false);
});

it('includes title', function () {
    // Arrange
    $course = Course::factory()->create();
    $expectedTitle = config('app.name') . ' - ' . $course->title;

    // Act
    $response = get(route('pages.course-details', $course))
        ->assertOk();

    // Assert
    $seo = new TestSEO($response->getContent());
    expect($seo->data)
        ->title()->toBe($expectedTitle);
});

it('includes social tags', function () {
    // Arrange
    $course = Course::factory()->released()->create();

    // Act
    $response = get(route('pages.course-details', $course))
        ->assertOk();

    // Assert
    $seo = new TestSEO($response->getContent());
    expect($seo->data)
        ->description()->toBe($course->description)
        ->openGraph()->type->toBe('website')
        ->openGraph()->url->toBe(route('pages.course-details', $course))
        ->openGraph()->title->toBe($course->title)
        ->openGraph()->description->toBe($course->description)
        ->openGraph()->image->toBe(asset("images/$course->image_name"))
        ->twitter()->card->toBe('summary_large_image');
});
