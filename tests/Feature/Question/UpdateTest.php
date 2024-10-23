<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, put};

it(
    'should be able to update a question',
    function () {
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $question = Question::factory()
           ->for($user, 'createdBy')
           ->create(['draft' => true]);

        put(route('question.update', $question), [
            'question' => 'Updated Question?',
        ]) ->assertRedirect(route('question.index'));

        $question->refresh();

        expect($question)->question->toBe('Updated Question?');
    }
);

it(
    'should make sure that only question with status DRAFT can be update',
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

        put(route('question.update', $questionNotDraft))
            ->assertForbidden();

        put(route('question.update', $draftQuestion), [
            'question' => 'Updated Question?',
        ])
        ->assertRedirect();
    }
);

it(
    'should make sure that only the person who has created the question can update the question',
    function () {
        /** @var User $rightUser */
        $rightUser = User::factory()->create();

        /** @var User $wrongUser */
        $wrongUser = User::factory()->create();

        $question = Question::factory()
            ->create(['draft' => true, 'created_by' => $rightUser->id]);

        actingAs($wrongUser);

        put(route('question.update', $question))
            ->assertForbidden();

        actingAs($rightUser);

        put(route('question.update', $question), [
            'question' => 'Updated Question?',
        ])
            ->assertRedirect();

    }
);

it(
    'should be able to create a new question bigger than 255 characters',
    function () {

        // Arrange :: preparar
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        actingAs($user);

        $question = Question::factory()
            ->for($user, 'createdBy')
            ->create(['draft' => true]);

        // Act :: agir
        $request = put(route('question.update', $question), [
            'question' => str_repeat('*', 260) . '?',
        ]);

        // Assert :: verificar
        $request->assertRedirect();
        assertDatabaseCount('questions', 1);
        assertDatabaseHas('questions', [
            'question' => str_repeat('*', 260) . '?',
        ]);
    }
);

it(
    'should check if ends with question mark ?',
    function () {
        // Arrange :: preparar
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        $question = Question::factory()
            ->for($user, 'createdBy')
            ->create(['draft' => true]);

        // Act :: agir
        $request = put(route('question.update', $question), [
            'question' => str_repeat('*', 10),
        ]);

        // Assert :: verificar
        $request->assertSessionHasErrors(
            ['question' => 'Are you sure that is a question? It is missing the question mark in the end.']
        );

        assertDatabaseHas('questions', [
            'question' => $question->question,
        ]);

    }
);

it(
    'should have at least 10 characters',
    function () {
        // Arrange :: preparar
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        actingAs($user);

        $question = Question::factory()
            ->for($user, 'createdBy')
            ->create(['draft' => true]);

        // Act :: agir
        $request = put(route('question.update', $question), [
            'question' => str_repeat('*', 8) . '?',
        ]);

        // Assert :: verificar
        $request->assertSessionHasErrors(
            ['question' => __(
                'validation.min.string',
                ['min' => 10, 'attribute' => 'question']
            )]
        );

        assertDatabaseHas('questions', [
            'question' => $question->question,
        ]);

    }
);
