<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index($cahnnelId, Thread $thread)
    {
//        dd(request()->url());
        return $thread->replies()->paginate(5);
    }

    public function store($channelId, Thread $thread)
    {
        if (Gate::denies('create', new Reply())) {
            return response(
                '发表评论太频繁',429
            );
        }

        try {
//            $this->authorize('create', new Reply());
            request()->validate(['body' => ['required', new SpamFree]]);

            $reply = $thread->addReply([
                'body'    => request('body'),
                'user_id' => auth()->id(),
            ]);
        } catch (\Exception $e) {
            return response(
                'sorry can\'t',422
            );
        }

        return $reply->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            request()->validate(['body' => ['required', new SpamFree]]);

            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response(
                'sorry can\'t', 422
            );
        }
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
