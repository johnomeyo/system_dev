<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
</head>
<body>
    <h3>Edit Blog</h3>
    <form action="/edit-blog/{{$blog->id}}" method="POST">
        @csrf
        @method('POST')
        <input type="text" name="title" value="{{$blog->title}}" required> <br>
        <textarea name="body" required>{{$blog->body}}</textarea> <br>
        <button type="submit">Edit</button>
</body>
</html>