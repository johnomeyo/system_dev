<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    @auth
     <h1>Welcome to bloghub</h1>
        <p>Welcome back, {{ auth()->user()->name }}!</p>
        <p>Create a blog</p>
        <form action="/create-blog" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Blog Title" required> <br>
        <textarea name="body" placeholder="Blog Body" required></textarea> <br>
        <button type="submit">Create Blog</button>
        </form>

        <form action="/logout" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>

        <div style="background-color: lightseagreen">
        <h2>YOUR blogs</h2>

        @foreach ($blogs as $blog)
        <div style="background-color: lightblue">
        <h3>{{$blog['title']}}</h3>
        <p>{{$blog['body']}}</p>
        <p>Author: {{$blog->user->name}}</p>
        <p>Created at: {{$blog->created_at}}</p>
        <p>Updated at: {{$blog->updated_at}}</p>
        <p><a href="/edit-blog/{{$blog->id}}">Edit</a></p>

        <form action="/delete-blog/{{$blog->id}}  ">
        @csrf
        @method('DELETE')
            <button type="submit">Delete</button>
        </form>
        </div>

            
        @endforeach

                </div>

    @else
    <div>
        <form action="/register" method="POST">
            @csrf
            <h1>Register</h1>
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" >
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
    <div>
        <form action="/login" method="POST">
            @csrf
            <h1>Login</h1>
            <input type="email" name="loginemail" placeholder="Email" >
            <input type="password" name="loginpassword" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
    @endauth


</body>
</html>