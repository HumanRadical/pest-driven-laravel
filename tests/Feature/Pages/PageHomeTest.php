<?php

use App\Models\Course;
use Carbon\Carbon;
use Juampi92\TestSEO\TestSEO;

use function Pest\Laravel\get;

it('shows courses overview', function () {
    // Arrange
    $courses = Course::factory(3)->released()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText([
            ...$courses->pluck('title')->toArray(),
            ...$courses->pluck('description')->toArray(),
        ]);
});

it('shows only released courses', function () {
    // Arrange
    $releasedCourse = Course::factory()->released()->create();
    $unreleasedCourse = Course::factory()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText($releasedCourse->title)
        ->assertDontSeeText($unreleasedCourse->title);
});

it('shows courses by release date', function () {
    // Arrange
    $oldCourse = Course::factory()->released(Carbon::yesterday())->create();
    $newCourse = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeTextInOrder([
            $newCourse->title,
            $oldCourse->title,
        ]);
});

it('includes login if not logged in', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Login')
        ->assertSee(route('login'));
});

it('includes logout if logged in', function () {
    // Arrange
    loginAsUser();

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Logout')
        ->assertSee(route('logout'));
});

it('does not find JetStream registration page', function () {
    // Act & Assert
    get('register')->assertNotFound();
});

it('includes courses links', function () {
    // Arrange
    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $thirdCourse = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSee([
            route('pages.course-details', $firstCourse),
            route('pages.course-details', $secondCourse),
            route('pages.course-details', $thirdCourse),
        ]);
});

it('includes title', function () {
    // Arrange
    $expectedTitle = config('app.name') . ' - Home';

    // Act
    $response = get(route('pages.home'))
        ->assertOk();

    // Assert
    $seo = new TestSEO($response->getContent());
    expect($seo->data)
        ->title()->toBe($expectedTitle);
});

it('includes social tags', function () {
    // Act
    $response = get(route('pages.home'))
        ->assertOk();

    // Assert
    $seo = new TestSEO($response->getContent());
    expect($seo->data)
        ->description()->toBe('LaravelCasts is the leading learning platform for Laravel developers.')
        ->openGraph()->type->toBe('website')
        ->openGraph()->url->toBe(route('pages.home'))
        ->openGraph()->title->toBe('LaravelCasts')
        ->openGraph()->description->toBe('LaravelCasts is the leading learning platform for Laravel developers.')
        ->openGraph()->image->toBe(asset('images/social.png'))
        ->twitter()->card->toBe('summary_large_image');
});
