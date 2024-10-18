<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it(
    'should be able tio publish a question',
    function () {
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $question = Question::factory()->create(['draft' => true]);

        put(route('question.publish', $question))
            ->assertRedirect();

        $question->refresh();

        expect($question)
            ->draft->toBeFalse();

    }
);
