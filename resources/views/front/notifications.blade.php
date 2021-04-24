<x-front-layout>
    <h2 class="mb-5">Notifications ({{ $unread }})</h2>
    <ul class="nav flex-column">
        @foreach($notifications as $notification)
        <li class="nav-item mb-4">
            <h5><a href="{{ route('notifications.read', [$notification->id]) }}">
                {{ $notification->data['title'] }}
                @if($notification->unread()) * @endif
            </a></h5>
            <div>{{ $notification->data['body'] }}</div>
            <div>{{ $notification->created_at->diffForHumans() }}</div>
        </li>
        @endforeach
    </ul>

</x-front-layout>