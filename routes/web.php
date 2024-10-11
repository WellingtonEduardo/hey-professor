<?php

use App\Http\Controllers\{DashboardController, ProfileController, Question, QuestionController};
use App\Models\User;
use Illuminate\Support\Facades\{Auth, Route};

Route::get('/', function () {

    if (app()->isLocal()) {

        $user = User::find(1);

        if ($user) {
            Auth::login($user);

            return to_route('dashboard');
        }
    }

    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/question/store', [QuestionController::class, 'store'])->name('question.store');
Route::post('/question/vote', Question\LikeController::class)->name('question.like');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
