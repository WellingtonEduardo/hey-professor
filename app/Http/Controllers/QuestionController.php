<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Http\{RedirectResponse, Request};

class QuestionController extends Controller
{
    public function index()
    {

        return view('question.index', [
            'questions' => Question::where('created_by', auth()->id())->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
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

        return back();
    }

    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->delete();

        return back();
    }
}
