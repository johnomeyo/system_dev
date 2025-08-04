<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create_blog(Request $request){

        $incomingFields = $request->validate([
            'title' => ['required', 'min:3', 'max:100'],
            'body' => ['required', 'min:10'],
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        Blog::create($incomingFields);

        return redirect('finance')->with('success', 'Blog created successfully!');
    }

    public function showEditScreen(Blog $blog){
        if ($blog->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    return view('edit-blog', [
            'blog' => $blog
        ]);
    }

    public function edit_blog(Blog $blog, Request $request){
        if ($blog->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $incomingFields = $request->validate([
            'title' => ['required', 'min:3', 'max:100'],
            'body' => ['required', 'min:10'],
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $blog->update($incomingFields);

        return redirect('/')->with('success', 'Blog updated successfully!');

    }

    public function delete_blog(Blog $blog){
        if ($blog->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $blog->delete();

        return redirect('/')->with('success', 'Blog deleted successfully!');
    }
}
