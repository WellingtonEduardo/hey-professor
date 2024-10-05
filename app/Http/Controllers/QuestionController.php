<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'question' => ['required']
        ]);

        Question::query()->create($attributes);

        return to_route('dashboard');
    }
}