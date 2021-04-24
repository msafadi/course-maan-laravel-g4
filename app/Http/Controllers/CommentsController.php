<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CommentsController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'content' => ['required'],
        ]);

        $comment = $post->comments()->create($request->all());

        $user = $post->user;
        if ($user) {
            $user->notify(new NewCommentNotification($comment));

            /*Notification::route('mail', 'msafadi@pnina.ps')
                ->route('mail', 'whatever@example.com')
                ->notify(new NewCommentNotification($comment));

            $users = User::whereIn('type', ['admin', 'super-admin'])->get();
            Notification::send($users, new NewCommentNotification($comment));*/
        }

        return redirect()->route('posts.show', [$post->id])
            ->with('success', 'Your comment added.');

    }
}
