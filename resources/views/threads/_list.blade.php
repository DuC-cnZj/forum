@forelse($threads as $thread)

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <div class="flex">
                    <h4>
                        @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                            <strong>
                                <a href="{{ $thread->path() }}">
                                    {{ $thread->title }}
                                </a>
                            </strong>
                        @else
                            <a href="{{ $thread->path() }}">
                                {{ $thread->title }}
                            </a>
                        @endif

                    </h4>

                    <h5>Posted By: <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                    </h5>
                </div>

                <a href="{{ $thread->path() }}"><strong>{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</strong></a>
            </div>
        </div>

        <div class="panel-body">
            <div class="body">{{ $thread->body  }}</div>
        </div>
    </div>
@empty
    <p>There Are No Threads At All</p>
@endforelse

