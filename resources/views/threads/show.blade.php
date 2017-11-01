@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8" v-cloak>
                    @include('threads._question')
                    <replies @added="repliesCount++"
                             @removed="repliesCount--"
                    ></replies>

                    {{--                    {{ $replies->links() }}--}}

                    {{--@signIn--}}
                    {{--<form action="{{ $thread->path() . "/replies" }}" method="POST">--}}
                    {{--{{ csrf_field() }}--}}
                    {{--<div class="form-group">--}}
                    {{--<textarea name="body" id="body" class="form-control" rows="5"--}}
                    {{--placeholder="have something to say?"></textarea>--}}
                    {{--</div>--}}

                    {{--<button type="submit" class="btn btn-default">Post</button>--}}
                    {{--</form>--}}
                    {{--@else--}}
                    {{--<p class="text-center">请 <a href="{{ route('login') }}">登陆</a> 之后再发表评论</p>--}}
                    {{--@endsignIn--}}
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                This Thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a>, and currently
                                has <span
                                        v-text="repliesCount"></span> {{ str_plural('reply', $thread->replies_count) }}
                                .
                            </p>

                            <p>
                                <subscribe-button
                                        :active="{{ json_encode($thread->isSubscribedTo) }}"
                                        v-if="signedIn"></subscribe-button>
                                <button class="btn btn-default"
                                        v-if="authorize('isAdmin')"
                                        @click="toggleLock"
                                        v-text="locked ? 'Unlock' : 'Lock'"></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
