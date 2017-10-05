@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} published a
        <a href="{{ $activity->subject->path() }}">
            {{ $activity->subject->title }}
        </a>.
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
{{--<div class="panel panel-default">--}}
{{--<div class="panel-heading">--}}
{{--<div class="level">--}}
{{--<span class="flex">--}}
{{--{{ $profileUser->name }} published a--}}
{{--<a href="{{ $activity->subject->path() }}">--}}
{{--{{ $activity->subject->title }}--}}
{{--</a>.--}}
{{--                            @include("profiles.activities.{$activity->type}")--}}
{{--<a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:--}}
{{--<a href="{{ $thread->path() }}">{{ $thread->title }}</a>--}}
{{--</span>--}}

{{--                                <span>{{ $thread->created_at->diffForHumans() }}</span>--}}
{{--</div>--}}
{{--</div>--}}

{{--<div class="panel-body">--}}
{{--{{ $activity->subject->body }}--}}
{{--</div>--}}
{{--</div>--}}

