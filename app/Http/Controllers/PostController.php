<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //
    public function list()
    {
        $data = Post::when(request('search'), function ($query) {
            $query->where('categories.title', 'like', '%' . request('search') . '%');
        })
            ->select('posts.*', 'categories.title as categoryTitle')
            ->leftJoin('categories', 'posts.category_id', 'categories.id')
            ->orderByDesc('posts.created_at')->paginate(15);
        $category = Category::get();
        $data->appends(request()->all());
        return view('admin.course.list', compact('data', 'category'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
            'category' => 'required'
        ]);
        $fileName = uniqid() . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public', $fileName);
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category,
            'image' => $fileName
        ]);

        return redirect()->route('course#list')->with([
            'status' => 'success'
        ]);
    }

    public function detail(Request $request)
    {
        $postData = Post::where('id', $request->id)->get();
        return response()->json($postData);
    }

    public function update(Request $request)
    {
        if ($request->hasFile('image')) {
            $post = Post::where('id', $request->id)->first();
            if ($post->image) {
                Storage::delete('public/' . $post->image);
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $post->image = $fileName;
        }
        Post::where('id', $request->id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id
        ]);
        return redirect()->route('course#list')->with([
            'update' => 'success'
        ]);
    }

    public function delete(Request $request)
    {
        Post::where('id', $request->id)->delete();
        return response()->json();
    }
}
