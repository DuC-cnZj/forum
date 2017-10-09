<div id="reply-{{ $reply->id }}" class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('profile', $reply->owner) }}">
                    {{ optional($reply->owner)->name }}
                </a> said {{ $reply->created_at->diffForHumans() }} ...
            </h5>

            <form action="/replies/{{ $reply->id }}/favorites" method="POST">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-default" {{ $reply->isFavorited() > 0 ? 'disabled' : '' }}>
                    {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
                </button>
            </form>
        </div>

    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>
</div>