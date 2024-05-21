<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = ['question', 'category_id', 'option', 'correct_option'];

    protected $casts = [
        'option' => 'array',
    ];
}
