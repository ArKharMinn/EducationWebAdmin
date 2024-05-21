<?php

use App\Http\Controllers\TeacherController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\InboxController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\StudentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('changeProfile', [AuthController::class, 'changeProfile']);
Route::post('changePassword', [AuthController::class, 'changePassword']);
Route::post('register', [AuthController::class, 'register']);
Route::get('category', [PostController::class, 'category']);
Route::post('searchCategory', [PostController::class, 'searchCategory']);
Route::post('details', [PostController::class, 'details']);
Route::post('getDetails', [PostController::class, 'getDetails']);
Route::get('quiz', [PostController::class, 'quiz']);
Route::post('quizScore', [PostController::class, 'quizScore']);
Route::post('user', [StudentUser::class, 'user']);
Route::post('chatList', [ChatController::class, 'chatList']);
Route::post('searchChat', [ChatController::class, 'searchChat']);
Route::get('teacher', [ChatController::class, 'teacher']);
Route::post('chatTeacher', [ChatController::class, 'chatTeacher']);
Route::post('contactTeacher', [ChatController::class, 'contactTeacher']);
Route::post('deleteMessage', [ChatController::class, 'deleteMessage']);
Route::post('inbox', [InboxController::class, 'inbox']);
Route::get('groupChat', [InboxController::class, 'groupChat']);
Route::post('sendMessage', [InboxController::class, 'sendMessage']);
Route::post('deleteGroupChatMessage', [InboxController::class, 'deleteGroupChatMessage']);
