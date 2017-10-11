<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId, Thread $thread)
    {
        request()->validate([
            'body' => 'required',
        ]);
        $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->id(),
        ]);

        return back()->with('flash', 'Your Reply has been left.');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        if ($reply->exists) {
            $this->authorize('update', $reply);

            $reply->delete();
        }

        if (request()->expectsJson()) {
            return response(['status' => 'reply deleted'], 204);
        }

        return back();
    }
}
