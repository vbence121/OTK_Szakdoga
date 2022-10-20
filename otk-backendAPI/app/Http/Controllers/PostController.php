<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getAll() {
        return Post::all();
    }

    public function getByPageNumber($pageNumber) {
        $postsPerPage = 5;
        $allPosts = Post::all()->sortByDesc("id")->toArray();
        $range_start = $postsPerPage * $pageNumber;

        return [
            'posts' =>  array_slice($allPosts, $range_start, $postsPerPage),
            'totalPosts' => count(Post::all()),
        ];
    }

    public function store(Request $request) {
        $fields = $request->validate([
            'content' => 'required|string',
            'title' => 'required|string',
        ],
        [
            'content.required' => 'A tartalom megadása kötelező!',
            'content.string' => 'A tartalom hibás!',
            'title.required' => 'A cím megadása kötelező!',
            'title.string' => 'A cím hibás!',
            
        ]);
        
        $post = Post::create([
            'content' => $fields['content'],
            'title' => $fields['title'],
        ]);

        return $post;
    }
}
