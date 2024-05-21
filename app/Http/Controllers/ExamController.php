<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    //
    public function list()
    {
        $post = Category::get();
        $quiz = Exam::when(request('search'), function ($query) {
            $query->where('categories.title', 'like', '%' . request('search') . '%');
        })
            ->select('exams.*', 'categories.title as category')
            ->leftJoin('categories', 'exams.category_id', 'categories.id')
            ->orderByDesc('exams.created_at')->paginate(10);
        $quiz->appends(request()->all());
        return view('admin.exam.list', compact('post', 'quiz'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'category_id' => 'required',
            'option' => 'required|array',
            'correct_option' => 'required',
        ]);

        Exam::create([
            'question' => $request->question,
            'category_id' => $request->category_id,
            'option' => $request->option,
            'correct_option' => $request->correct_option,
        ]);

        return redirect()->route('quiz#list')->with([
            'create' => 'success'
        ]);
    }

    public function detail(Request $request)
    {
        $detail = Exam::where('id', $request->id)->get();
        return response()->json($detail);
    }

    public function update(Request $request)
    {
        $data = [
            'question' => $request->question,
            'category_id' => $request->category_id,
            'option' => $request->option,
            'correct_option' => $request->correct_option,
        ];

        Exam::where('id', $request->id)->update($data);
        return redirect()->route('quiz#list')->with([
            'update' => 'success'
        ]);
    }

    public function delete(Request $request)
    {
        Exam::where('id', $request->id)->delete();
        return response()->json();
    }
}
