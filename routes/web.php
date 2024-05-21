<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgetPassword;
use App\Http\Controllers\PostController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\GoogleAuth;
use App\Http\Controllers\GroupChatController;
use App\Models\Contact;
use App\Models\Exam;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login');
Route::get('login', [AdminController::class, 'login'])->name('login');
Route::get('register', [AdminController::class, 'register'])->name('register');
Route::get('logout', [AdminController::class, 'logout'])->name('logout');

//google login
Route::get('/auth/google/redirect', [GoogleAuth::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleAuth::class, 'callback']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::prefix('dashboard')->group(function () {
        Route::get('teacher', [AdminController::class, 'teacher'])->name('dashboard#teacher');
        Route::get('student', [AdminController::class, 'student'])->name('dashboard#student');
    });
    Route::prefix('student')->group(function () {
        Route::get('list', [StudentController::class, 'list'])->name('student#list');
        Route::get('detail', [StudentController::class, 'detail'])->name('student#detail');
        Route::get('delete', [StudentController::class, 'delete'])->name('student#delete');
    });
    Route::prefix('teacher')->group(function () {
        Route::get('list', [TeacherController::class, 'list'])->name('teacher#list');
        Route::get('detail', [TeacherController::class, 'detail'])->name('teacher#detail');
        Route::get('delete', [TeacherController::class, 'delete'])->name('teacher#delete');
        Route::get('add', [TeacherController::class, 'add'])->name('teacher#add');
        Route::post('create', [TeacherController::class, 'create'])->name('teacher#create');
        Route::get('changeRole', [TeacherController::class, 'changeRole'])->name('teacher#changeRole');
    });
    Route::prefix('inbox')->group(function () {
        Route::get('list', [ContactController::class, 'list'])->name('inbox#list');
        Route::get('chat', [ContactController::class, 'chat'])->name('inbox#chat');
        Route::get('delete/{id}', [ContactController::class, 'delete'])->name('inbox#delete');
        Route::post('sendMessage', [ContactController::class, 'sendMessage'])->name('inbox#sendMessage');
    });
    Route::prefix('groupChat')->group(function () {
        Route::get('list', [GroupChatController::class, 'list'])->name('groupChat#list');
        Route::post('send', [GroupChatController::class, 'send'])->name('groupChat#send');
        Route::get('delete{id}', [GroupChatController::class, 'delete'])->name('groupChat#delete');
    });
    Route::prefix('category')->group(function () {
        Route::get('list', [CategoryController::class, 'list'])->name('category#list');
        Route::post('create', [CategoryController::class, 'create'])->name('category#create');
        Route::get('detail', [CategoryController::class, 'detail'])->name('category#detail');
        Route::post('update', [CategoryController::class, 'update'])->name('category#update');
        Route::get('delete', [CategoryController::class, 'delete'])->name('category#delete');
    });
    Route::prefix('course')->group(function () {
        Route::get('list', [PostController::class, 'list'])->name('course#list');
        Route::post('create', [PostController::class, 'create'])->name('course#create');
        Route::get('detail', [PostController::class, 'detail'])->name('course#detail');
        Route::post('update', [PostController::class, 'update'])->name('course#update');
        Route::get('delete', [PostController::class, 'delete'])->name('course#delete');
    });
    Route::prefix('quiz')->group(function () {
        Route::get('list', [ExamController::class, 'list'])->name('quiz#list');
        Route::post('create', [ExamController::class, 'create'])->name('quiz#create');
        Route::get('detail', [ExamController::class, 'detail'])->name('quiz#detail');
        Route::post('update', [ExamController::class, 'update'])->name('quiz#update');
        Route::get('delete', [ExamController::class, 'delete'])->name('quiz#delete');
    });
    Route::prefix('admin')->group(function () {
        Route::get('list', [AdminController::class, 'list'])->name('admin#list');
        Route::get('detail', [AdminController::class, 'detail'])->name('admin#detail');
        Route::get('delete', [AdminController::class, 'delete'])->name('admin#delete');
        Route::get('changeRole', [AdminController::class, 'changeRole'])->name('admin#changeRole');
    });

    Route::prefix('setting')->group(function () {
        Route::get('manage', [AdminController::class, 'manage'])->name('setting#manage');
        Route::get('editProfile', [AdminController::class, 'editProfile'])->name('setting#editProfile');
        Route::post('updateProfile', [AdminController::class, 'updateProfile'])->name('setting#updateProfile');
        Route::get('deletepp/{id}', [AdminController::class, 'deletepp'])->name('setting#deletepp');
        Route::get('deleteAcc', [AdminController::class, 'deleteAcc'])->name('setting#deleteAcc');
        Route::post('change', [AdminController::class, 'change'])->name('setting#change');
    });
});
