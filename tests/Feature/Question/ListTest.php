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
                ->assertViewHas(
                    'questions',
                    function ($value) {
                        return $value instanceof LengthAwarePaginator;
                    }
                );

    }
);

it(
    'should order by like and unlike, most liked question should be at the top, most unliked questions should be at the bottom',
    function () {
        // Arrange
        /** @var User $user */
        $user       = User::factory()->create();
        $secondUser = User::factory()->create();
        Question::factory()->count(5)->create();
        $mostLikedQuestion   = Question::find(3);
        $mostUnlikedQuestion = Question::find(4);
        $user->like($mostLikedQuestion);
        $secondUser->unlike($mostUnlikedQuestion);

        actingAs($user);

        // Act
        get(route('dashboard'))
                ->assertViewHas(
                    'questions',
                    function ($questions) use ($mostLikedQuestion, $mostUnlikedQuestion) {

                        expect($questions)
                            ->first()->id->toBe(3)
                            ->and($questions)
                            ->last()->id->toBe(4);

                        return true;
                    }
                );

    }
);
