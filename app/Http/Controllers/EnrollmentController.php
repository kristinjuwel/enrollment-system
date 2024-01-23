<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrolled;
use Illuminate\Support\Facades\Auth;


class EnrollmentController extends Controller
{


    public function totalSummary()
{
    $enrollments = Enrolled::where('student_id', Auth::id())->get();
    return view('student.enrollment_summary_total', ['enrollments' => $enrollments]);
}

    
}

