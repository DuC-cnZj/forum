@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} Reply to
        <a href="{{ $activity->subject->thread->path() }}">
            {{ $activity->subject->thread->title }}
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
{{--                            @include("profiles.activities.{$activity->type}")--}}
{{--{{ $profileUser->name }} Reply to--}}
{{--<a href="{{ $activity->subject->thread->path() }}">--}}
{{--{{ $activity->subject->thread->title }}--}}
{{--</a>.--}}
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

