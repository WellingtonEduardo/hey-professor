<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

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
        ]) ->assertRedirect();

        $question->refresh();

        expect($question)->question->toBe('Updated Question?');
    }
);
