<x-admin-layout title="Edit Post">

    <form action="{{ route('admin.posts.update', [$post->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- Form Method Spoofing --}}
        @method('put')

        @include('admin.posts._form', [
            'saveLabel' => 'Update'
        ])
    </form>

</x-admin-layout>