<x-admin-layout :title="__('Posts')">
    @can('posts.create')
    <div class="mb-4">
        <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-outline-primary">{{ __('Create New') }}</a>
    </div>
    @endif

    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
        {{-- session('success') --}}
    </div>
    @endif
    
    <p>{{ __('There are :count of :total posts', ['total' => $posts->total(), 'count' => $posts->count()]) }}</p>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>@lang('ID')</th>
                <th>@lang('Title')</th>
                <th>{{ trans('Slug') }}</th>
                <th>{{ __('Category') }}</th>
                <th>{{ __('Tags') }}</th>
                <th>{{ Lang::get('Status') }}</th>
                <th>{{ __('User') }}</th>
                <th>{{ __('Created At') }}</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td><a href="{{ route('admin.posts.image', [$post->id]) }}">
                    <img src="{{ $post->image_url }}" height="60" alt="">
                </a></td>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->slug }}</td>
                <td>{{ $post->category->name }}</td>
                <td>
                @foreach($post->tags as $tag)
                <span class="badge badge-info">{{ $tag->name }}</span>
                @endforeach
                </td>
                <td>{{ $post->status }}</td>
                <td>{{ $post->user_id }}</td>
                <td>{{ $post->created_at }}</td>
                <td>
                @can('posts.update')
                <a href="{{ route('admin.posts.edit', [$post->id]) }}" class="btn btn-sm btn-outline-success">{{ __('Edit') }}</a></td>
                @endcan
                <td>
                @can('posts.delete')
                <form action="{{ route('admin.posts.destroy', [$post->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                </form>
                @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10">No Posts Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $posts->links() }}
</x-admin-layout>
