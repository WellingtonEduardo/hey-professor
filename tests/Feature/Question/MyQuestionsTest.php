<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it(
    'should be able to list all question created by me',
    function () {

        /** @var User $wrongUser */
        $wrongUser = User::factory()->create();

        $wrongQuestions = Question::factory()
           ->for($wrongUser, 'createdBy')
           ->count(10)
           ->create();

        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $questions = Question::factory()
           ->for($user, 'createdBy')
           ->count(10)
           ->create();

        $response = get(route('question.index'));

        /** @var Question $q */
        foreach ($questions as $q) {
            $response->assertSee($q->question);
        }

        /** @var Question $q */
        foreach ($wrongQuestions as $q) {
            $response->assertDontSee($q->question);
        }

    }
);
