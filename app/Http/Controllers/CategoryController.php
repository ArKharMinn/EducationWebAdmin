<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function list(Request $request){
        $data = Category::when(request('search'),function($query){
            $query->where('title','like','%'.request('search').'%');
        })
        ->orderBy('created_at','desc')->paginate(10);
        $data->appends(request()->all());
        return view('admin.category.list',compact('data'));
    }

    public function create(Request $request){
        $request->validate([
            'title' => 'required|unique:categories,title',
            'description' => 'required'
        ]);
        $data = $this->createData($request);
        Category::create($data);
        return redirect()->route('category#list')->with([
            'status' => 'success'
        ]);
    }

    public function detail(Request $request){
        $data = Category::where('id',$request->id)->get();
        return response()->json($data);
    }

    public function update(Request $request){
        $data = [
            'title' => $request->title,
            'description' => $request->description
        ];
        Category::where('id',$request->id)->update($data);
        return redirect()->route('category#list')->with([
            'update' => 'success'
        ]);
    }

    public function delete(Request $request){
        Category::where('id',$request->id)->delete();
        return response()->json();
    }

    private function createData($request){
        return [
            'title' => $request->title,
            'description' => $request->description
        ];
    }
}
