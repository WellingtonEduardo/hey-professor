<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse};

class QuestionController extends Controller
{
    public function index(): View
    {

        return view('question.index', [
            'questions' => Question::where('created_by', auth()->id())->get(),
        ]);

    }

    public function store(): RedirectResponse
    {

        request()->validate([
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
            'question' => request()->question,
        ]);

        return back();
    }

    public function edit(Question $question): View
    {
        $this->authorize('edit', $question);

        return view('question.edit', compact('question'));
    }

    public function update(Question $question): RedirectResponse
    {
        $this->authorize('update', $question);

        request()->validate([
            'question' => [
                'required',
                'min:10',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (substr($value, -1) != '?') {
                        $fail('Are you sure that is a question? It is missing the question mark in the end.');
                    }
                }, ],
        ]);

        $question->question = request()->question;
        $question->save();

        return to_route('question.index');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->delete();

        return back();
    }
}
