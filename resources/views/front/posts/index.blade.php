<x-front-layout>
    <h2>Articles</h2>

    @foreach ($posts as $post)
    <article>
        <h3>{{ $post->category->name }} - {{ $post->title }}</h3>
        <p>{{ $post->content }}</p>
        <a href="{{ route('posts.show', [$post->id]) }}">Read more</a>
    </article>
    <hr>
    @endforeach
</x-front-layout>