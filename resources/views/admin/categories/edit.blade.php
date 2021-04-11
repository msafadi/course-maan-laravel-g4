<x-admin-layout title="Edit Category">

    <form action="{{ route('admin.categories.update', [$category->id]) }}" method="post">
        @csrf
        {{-- Form Method Spoofing --}}
        @method('put')

        @include('admin.categories._form', [
            'saveLabel' => 'Update'
        ])
    </form>

</x-admin-layout>