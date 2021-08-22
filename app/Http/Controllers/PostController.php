<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts =  Post::get();

        return $this->setResponse(compact('posts'));
    }

    public function show($id)
    {
        $post =  Post::find($id);

        return $this->setResponse(compact('post'));
    }

    public function store(Request $request)
    {
        $message = '';
        try {
            $post = new Post();
            $post->title = $request->title;
            $post->body = $request->body;

            if ($post->save()) {
                $message = 'Post created succesfully';

                return $this->setResponse(compact('message'));
            }
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->code = 500;

            $message = $e->getMessage();
            return $this->setResponse(compact('message'));
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->title = $request->title;
            $post->body = $request->body;

            if ($post->save()) {
                $message = 'Post updated succesfully';

                return $this->setResponse(compact('message'));
            }
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->code = 500;

            $message = $e->getMessage();
            return $this->setResponse(compact('message'));
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->delete()) {
                $message = 'Post deleted succesfully';

                return $this->setResponse(compact('message'));
            }
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->code = 500;

            $message = $e->getMessage();
            return $this->setResponse(compact('message'));
        }
    }
}
