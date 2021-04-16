<x-admin-layout title="Create New Post">

    <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        
        @include('admin.posts._form', [
            'saveLabel' => 'Add'
        ])
    </form>

</x-admin-layout>