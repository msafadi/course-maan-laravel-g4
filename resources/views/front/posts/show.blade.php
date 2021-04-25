<x-front-layout>
    <article class="my-5">
        <h2>{{ $post->title }}</h2>
        <p>{!! $post->content !!}</p>
    </article>
    <form action="{{ route('comments.store', [$post->id]) }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label for="">Comment</label>
            <textarea name="content" class="form-control" rows="4">{{ old('content') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</x-front-layout>