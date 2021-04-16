<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
</head>
<body>
    <h2>Articles</h2>

    @foreach ($posts as $post)
    <article>
        <h3>{{ $post->title }}</h3>
        <p>{{ $post->content }}</p>
        <a href="{{ route('articles.show', [$post->id]) }}">Read more</a>
    </article>
    <hr>
    @endforeach
</body>
</html>