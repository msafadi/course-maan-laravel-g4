<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
</head>
<body>
    <h2>Categories</h2>

    <ul>
        @foreach ($categories as $category)
        <li><a href="{{ route('categories.show', [$category->id]) }}">{{ $category->name }}</a></li>
        @endforeach
    </ul>
</body>
</html>