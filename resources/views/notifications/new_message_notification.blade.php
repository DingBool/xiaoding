<li class="notifications {{ $notification->unread() ? 'unread' : '' }}">
    {{--<a href="/inbox/{{ $notification -> data['dialog'] }}">{{ $notification -> data['name'] }}  给您发了一条私信!</a>--}}
    <a href="/notifications/{{ $notification->id }}?redirect_url=/inbox/{{ $notification->data['dialog'] }}">{{ $notification -> data['name'] }}  给您发了一条私信!</a>
</li>