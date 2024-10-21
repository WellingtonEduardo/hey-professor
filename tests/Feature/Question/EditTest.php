<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it(
    'should be able to open a question edit',
    function () {
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $question = Question::factory()
           ->for($user, 'createdBy')
           ->create();

        get(route('question.edit', $question))
            ->assertSuccessful();
    }
);
