<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

it(
    'should be able to like a question',
    function () {
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $question = Question::factory()->create();

        post(route('question.like', $question))->assertRedirect();

        assertDatabaseHas('votes', [
            'question_id' => $question->id,
            'like'        => 1,
            'unlike'      => 0,
            'user_id'     => $user->id,
        ]);

    }
);

it(
    'should not be able to like more than one time',
    function () {
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $question = Question::factory()->create();

        post(route('question.like', $question));
        post(route('question.like', $question));
        post(route('question.like', $question));
        post(route('question.like', $question));

        expect($user->votes()->where('question_id', '=', $question->id)->get())
            ->toHaveCount(1);

    }
);