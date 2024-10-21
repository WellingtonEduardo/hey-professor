<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseMissing, delete};

it(
    'should be able to destroy a question',
    function () {
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

        delete(route('question.destroy', $question))
            ->assertRedirect();

        assertDatabaseMissing('questions', ['id' => $question->id]);

    }
);

it(
    'should make sure that only the person who has created the question can destroy the question',
    function () {
        /** @var User $rightUser */
        $rightUser = User::factory()->create();

        /** @var User $wrongUser */
        $wrongUser = User::factory()->create();

        $question = Question::factory()
            ->create(['draft' => true, 'created_by' => $rightUser->id]);

        actingAs($wrongUser);

        delete(route('question.destroy', $question))
            ->assertForbidden();

        actingAs($rightUser);

        delete(route('question.destroy', $question))
            ->assertRedirect();

    }
);
