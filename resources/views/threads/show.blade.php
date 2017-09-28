@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        @signIn
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="{{ $thread->path() . "/replies" }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea name="body" id="body" class="form-control" rows="5" placeholder="have something to say?"></textarea>
                    </div>

                    <button type="submit" class="btn btn-default">Post</button>
                </form>
            </div>
        </div>
        @else
            <p class="text-center">请 <a href="{{ route('login') }}">登陆</a> 之后再发表评论</p>
        @endsignIn
    </div>
@endsection
