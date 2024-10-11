<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        return back();
    }
}
