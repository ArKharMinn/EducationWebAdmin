<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'to_userId',
        'from_userId',
        'student_id',
        'teacher_id',
        'admin_id'
    ];
}
