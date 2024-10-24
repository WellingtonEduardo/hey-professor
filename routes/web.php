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

Route::middleware(['verified', 'auth'])->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    #region Question routes
    Route::get('/question', [QuestionController::class, 'index'])->name('question.index');
    Route::post('/question/store', [QuestionController::class, 'store'])->name('question.store');
    Route::get('/question/{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
    Route::put('/question/{question}', [QuestionController::class, 'update'])->name('question.update');
    Route::delete('/question/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');
    Route::post('/question/like/{question}', Question\LikeController::class)->name('question.like');
    Route::post('/question/unlike/{question}', Question\UnlikeController::class)->name('question.unlike');
    Route::put('/question/publish/{question}', Question\PublishController::class)->name('question.publish');
    #endregion

    #region Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    #endregion
});

require __DIR__ . '/auth.php';
