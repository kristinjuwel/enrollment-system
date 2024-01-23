<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'course_name',
        'slots',
    ];

    // Define the relationship with the professor
    public function professor()
    {
        return $this->belongsTo(User::class, 'prof_id');
    }


    public function enrolledStudents()
{
    return $this->hasMany(Enrolled::class, 'subject_id');
}

}
