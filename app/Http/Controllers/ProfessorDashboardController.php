<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\Enrolled;


class ProfessorDashboardController extends Controller
{
    public function index()
    {
        // Check if the authenticated user is a professor
        if (Auth::user()->role === 'professor') {
            // Retrieve all subjects created by the professor
            //$subjects = Subject::where('prof_id', Auth::id())->get();
            //return view('professor.dashboard', compact('subjects'));

            $subjects = Subject::where('prof_id', Auth::user()->id)->get();
            //$subjects = Subject::all(); // Get all subjects
            $subjects = collect($subjects); // Convert to collection

            $enrollments = Enrolled::where('prof_id', Auth::user()->id)->get(); // all enrollment records where people are enrolled to this prof
            $enrollments = collect($enrollments);

            $students = User::all();
            $students = collect($students);
            return view('professor.dashboard', compact('subjects', 'enrollments', 'students'));
        }

        // Redirect to the student dashboard if the user is not a professor
        return redirect()->route('student.dashboard');
    }

    public function createSubject(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required',
            'course_name' => 'required',
            'slots' => 'required|integer',
        ]);
    
        $subject = new Subject();
        $subject->course_id = $validatedData['course_id'];
        $subject->course_name = $validatedData['course_name'];
        $subject->slots = $validatedData['slots'];
        $subject->prof_id = Auth::id(); // Set the prof_id with the user_id of the authenticated professor
        $subject->save();
    
        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    public function viewEnrolledStudents($subjectId)
    {
        $subject = Subject::findOrFail($subjectId);
    
        if ($subject->prof_id != Auth::id()) {
            return redirect()->route('professor.dashboard')->with('error', 'You do not have permission to view enrolled students for this subject.');
        }
    
        $enrolledStudents = $subject->enrolledStudents;
    
        return view('professor.enrolled_students', compact('subject', 'enrolledStudents'));
    }
    

    public function removeEnrollment($subjectId, $enrollmentId)
    {
        $subject = Subject::findOrFail($subjectId);

        // Check if the authenticated professor is the owner of the subject
        if ($subject->prof_id != Auth::id()) {
            return redirect()->route('professor.dashboard')->with('error', 'You do not have permission to remove enrolled students for this subject.');
        }

        $enrollment = Enrolled::findOrFail($enrollmentId);
        $enrollment->delete();

        // Increment the slot count by 1
        $subject->slots += 1;
        $subject->save();

        return redirect()->back()->with('success', 'Enrollment removed successfully.');
    }
    public function editProfile()
    {
        $user = Auth::user();
        return view('professor.profile_edit', compact('user'));
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|unique:users,username,' . $user->id,
        ]);

        $user->update([
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
        ]);

        return redirect()->route('professor.dashboard')->with('success', 'Profile updated successfully!');
    }
    
}
