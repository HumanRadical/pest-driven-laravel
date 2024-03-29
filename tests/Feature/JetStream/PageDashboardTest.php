<?php

use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\get;

it('cannot be accessed by a guest', function () {
    // Act & Assert
    get(route('pages.dashboard'))
        ->assertRedirect(route('login'));
});

it('lists purchased courses', function () {
    // Arrange
    loginAsUser(
        User::factory()
            ->has(Course::factory(2)->state(new Sequence(
                ['title' => 'Course A'],
                ['title' => 'Course B'],
            )), 'purchasedCourses')
            ->create()
    );

    // Act & Assert
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText([
            'Course A',
            'Course B',
        ]);
});

it('does not list unpurchased courses', function () {
    // Arrange
    loginAsUser();
    $course = Course::factory()->create();

    // Act & Arrange
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertDontSeeText($course->title);
});

it('shows latest purchased course first', function () {
    // Arrange
    $user = loginAsUser();
    $firstPurchasedCourse = Course::factory()->create();
    $lastPurchasedCourse = Course::factory()->create();

    $user->purchasedCourses()->attach($firstPurchasedCourse, ['created_at' => Carbon::yesterday()]);
    $user->purchasedCourses()->attach($lastPurchasedCourse, ['created_at' => Carbon::now()]);

    // Act & Assert
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeInOrder([
            $lastPurchasedCourse->title,
            $firstPurchasedCourse->title,
        ]);
});

it('includes link to course videos', function () {
    // Arrange
    loginAsUser(
        User::factory()
            ->has(Course::factory(), 'purchasedCourses')
            ->create()
    );

    // Act & Assert
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Watch videos')
        ->assertSee(route('pages.course-videos', Course::first()));
});

it('includes logout', function () {
    // Arrange
    loginAsUser();

    // Act & Assert
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Log Out')
        ->assertSee(route('logout'));
});
