<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use App\User;

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

    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        $reply = $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->id(),
        ]);
        // 查看 body 是否 @ 人
        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);
//        dd($matches);
        foreach ($matches[1] as $name) {
            $user = User::whereName($name)->first();

            if ($user) {
                $user->notify(new YouWereMentioned($reply));
            }
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
