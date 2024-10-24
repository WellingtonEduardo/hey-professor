<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertSoftDeleted, patch};

it(
    'should be able to archive a question',
    function () {
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $question = Question::factory()
            ->for($user, 'createdBy')
            ->create(['draft' => true]);

        patch(route('question.archive', $question))
            ->assertRedirect();

        assertSoftDeleted('questions', ['id' => $question->id]);

        expect($question)
            ->refresh()
            ->deleted_at->not->toBeNull();
    }
);

it(
    'should make sure that only the person who has created the question can archive the question',
    function () {
        /** @var User $rightUser */
        $rightUser = User::factory()->create();

        /** @var User $wrongUser */
        $wrongUser = User::factory()->create();

        $question = Question::factory()
            ->create(['draft' => true, 'created_by' => $rightUser->id]);

        actingAs($wrongUser);

        patch(route('question.archive', $question))
            ->assertForbidden();

        actingAs($rightUser);

        patch(route('question.archive', $question))
            ->assertRedirect();

    }
);
