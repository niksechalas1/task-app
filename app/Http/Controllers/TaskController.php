<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $postData = $request->all();
        if ($postData) {
            $post = new Task();
            $post->user_id = auth()->user()->id;
            $post->title = $postData['title'];
            $post->content = $postData['content'];
            if ($post->save()) {
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false]);
    }
    public function update(Request $request, $id)
    {
        $postData = $request->all();
        if ($postData) {
            $post = Task::find($id);
            if ($post) {
                $post->title = $postData['title'];
                $post->content = $postData['content'];
                if ($post->save()) {
                    return response()->json(['success' => true]);
                }
            }
        }

        return response()->json(['success' => false]);
    }
    public function destroy($id)
    {
        $post = Task::find($id);
        if ($post) {
            $post->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function all()
    {
        $posts = Task::where('user_id', auth()->user()->id)->get();
        return response()->json(
            [
                'success' => true,
                'data' => $posts
            ]
        );
    }
}
