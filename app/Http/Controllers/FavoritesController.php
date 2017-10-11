<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * FavoritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Reply $reply
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(Reply $reply)
    {
        $reply->favorite();

        return back();
//        $reply->favorites()->create(['user_id', auth()->id()]);
//        Favorite::create([
//            'user_id'       => auth()->id(),
//            'favorited_id'   => $reply->id,
//            'favorited_type' => get_class($reply),
//        ]);
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorited();
    }
}
