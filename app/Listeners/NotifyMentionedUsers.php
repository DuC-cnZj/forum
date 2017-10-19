<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        // 查看 body 是否 @ 人
//        preg_match_all('/\@([^\s\.]+)/', $event->reply->body, $matches);
//        dd($matches);
//        $mentionedUsers = $event->reply->mentionedUsers();

        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each
            ->notify(new YouWereMentioned($event->reply));
//        collect($event->reply->mentionedUsers())
//            ->map(function ($name) {
//                return User::whereName($name)->first();
////                if ($user) return $user;
//            })
//            ->filter()
//            ->each(function ($user) use ($event) {
//                $user->notify(new YouWereMentioned($event->reply));
//            });
//
//        foreach ($mentionedUsers as $name) {
//            $user = User::whereName($name)->first();
//
//            if ($user) {
//                $user->notify(new YouWereMentioned($event->reply));
//            }
//        }
    }
}
