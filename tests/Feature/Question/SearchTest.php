<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it(
    'should be able to search a question by text',
    function () {
        /** @var User $user */
        $user = User::factory()->create();
        actingAs($user);

        Question::factory()->create(['question' => 'Something else?']);
        Question::factory()->create(['question' => 'My question is?']);

        $response = get(route('dashboard', ['search' => 'question']));

        $response->assertDontSee('Something else?');

        $response->assertSee('My question is?');

    }
);
