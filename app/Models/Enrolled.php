<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrolled extends Model
{
    use HasFactory;

    protected $table = 'enrolled';

    protected $fillable = [
        'course_id',
        'student_id',
        'prof_id',
        'subject_id', // Add subject_id to the $fillable array
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}


