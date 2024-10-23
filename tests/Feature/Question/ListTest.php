<?php

use App\Models\{Question, User};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it(
    'should list all the questions',
    function () {
        // Arrange
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $questions = Question::factory()->count(5)->create();

        // Act
        $response = get(route('dashboard'));

        // Assert
        /** @var Question $q */
        foreach ($questions as $q) {
            $response->assertSee($q->question);
        }

    }
);

it(
    'should paginate the result',
    function () {
        // Arrange
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        Question::factory()->count(20)->create();

        // Act
        get(route('dashboard'))
                ->assertViewHas('questions', function ($value) {
                    return $value instanceof LengthAwarePaginator;
                });

    }
);
