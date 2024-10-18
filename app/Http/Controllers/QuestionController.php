<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\{Request};

class QuestionController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'question' => [
                'required',
                'min:10',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (substr($value, -1) != '?') {
                        $fail('Are you sure that is a question? It is missing the question mark in the end.');
                    }
                }, ],
        ]);

        user()->questions()->create([
            'draft'    => true,
            'question' => $request->question,
        ]);

        return to_route('dashboard');
    }
}
