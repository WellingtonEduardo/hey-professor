<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\SameQuestionRule;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse};

class QuestionController extends Controller
{
    public function index(): View
    {
        $questions = Question::withTrashed()->where('created_by', auth()->id())->get();

        return view('question.index', [
            'questions'         => $questions->whereNull('deleted_at'),
            'archivedQuestions' => $questions->whereNotNull('deleted_at'),
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
                },
                new SameQuestionRule(),
            ],
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

    public function archive(Question $question): RedirectResponse
    {
        $this->authorize('arquive', $question);

        $question->delete();

        return back();
    }

    public function restore(int $id): RedirectResponse
    {

        $question = Question::withTrashed()->find($id);
        $this->authorize('restore', $question);

        $question->restore();

        return back();
    }

    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->forceDelete();

        return back();
    }
}
