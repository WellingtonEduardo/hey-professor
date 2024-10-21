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
           ->create(['draft' => true]);

        get(route('question.edit', $question))
            ->assertSuccessful();
    }
);

it(
    'should return view',
    function () {
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $question = Question::factory()
           ->for($user, 'createdBy')
           ->create(['draft' => true]);

        get(route('question.edit', $question))
            ->assertViewIs('question.edit');
    }
);

it(
    'should make sure that only question with status DRAFT can be edited',
    function () {
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $questionNotDraft = Question::factory()
           ->for($user, 'createdBy')
           ->create(['draft' => false]);

        $draftQuestion = Question::factory()
           ->for($user, 'createdBy')
           ->create(['draft' => true]);

        get(route('question.edit', $questionNotDraft))
            ->assertForbidden();

        get(route('question.edit', $draftQuestion))
        ->assertSuccessful();
    }
);
