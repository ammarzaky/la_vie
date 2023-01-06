<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::select('title', 'description')->paginate(10);
        return response()->json($posts);
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->all();
        try {
            $data = $request->all();

            if ($request->has('image') && $request->image) {
                $data['image'] = Storage::disk('public')->putFile('images/posts', $request->file('image'));
            } else {
                $data['image'] = "image.png";
            }

            if ($data = Post::create($data)) {
                $msg = 'Post added successfully';
                return response()->json(["success" => true, 'msg' =>  $msg, 'data' => $data->load('user')], 200);
            };
        } catch (\Exception $error) {
            return response()->json(["error" => $error->getMessage(), "line" => $error->getLine()], 500);
        }
    }

    public function show(int $id)
    {
        $post = Post::where('id', $id)->with('user')->first();
        return response()->json($post);
    }
}