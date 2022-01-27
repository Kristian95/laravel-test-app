<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Comment;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $userTasks = Task::whereHas('comments')
            ->with([
                'comments' => function ($query) {
                    $query->where('created_at', '>', Carbon::now()->subHours(12))
                        ->orderBy('created_at', 'asc');
                },
                'comments.user'])
            ->get();

        $commentsWithUsers = Comment::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    }
}