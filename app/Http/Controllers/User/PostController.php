<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Post;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    public function category()
    {
        $category = Category::get();
        return response()->json($category);
    }

    public function searchCategory(Request $request)
    {
        $searchCategory = Category::where('title', 'like', '%' . $request->key . '%')->get();
        return response()->json($searchCategory);
    }

    public function details(Request $request)
    {
        $lesson = Post::where('category_id', $request->id)
            ->select('posts.*', 'categories.title as category')
            ->leftJoin('categories', 'posts.category_id', 'categories.id')
            ->get();
        return response()->json([
            'lesson' => $lesson
        ]);
    }

    public function getDetails(Request $request)
    {
        $getLesson = Post::where('title', 'like', '%' . $request->title . '%')->get();
        return response()->json($getLesson);
    }

    public function quiz(Request $request)
    {
        $quiz = Exam::inRandomOrder()->get();
        return response()->json([
            'quiz' => $quiz
        ]);
    }

    public function quizScore(Request $request)
    {
        $student = Student::where('student_id', $request->id)->first();
        if ($student) {
            $student->update([
                'score' => $request->score
            ]);
            return response()->json([
                'score' => 'stored'
            ]);
        };
    }
}
