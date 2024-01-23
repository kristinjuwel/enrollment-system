<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Enrolled;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        // Retrieve all subjects from the database
        $subjects = Subject::where('prof_id', Auth::user()->id)->get();
        $subjects = collect($subjects); // Convert to collection
    
        // Retrieve all enrollments from the database
        $enrollments = Enrolled::where('prof_id', Auth::user()->id)->get(); // all enrollment records where people are enrolled to this prof
        $enrollments = collect($enrollments);
    
        // Retrieve all students from the database
        $students = User::where('role', 'student')->get();
    
    
        // Pass the subjects, enrollments, and students to the view for display
        return view('professor.subjects.subjects', compact('subjects', 'enrollments', 'students'));
    }

    public function create()
    {
        return view('professor.subjects.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_name' => 'required|string',
            'slots' => 'required|integer|min:1',
        ]);

        // Create a new subject using the authenticated professor's ID
        Subject::create([
            'course_id' => uniqid(), // Generate a unique course ID
            'course_name' => $validatedData['course_name'],
            'slots' => $validatedData['slots'],
            'prof_id' => Auth::id(),
        ]);

        return redirect()->route('professor.subjects.subjects')->with('success', 'Subject created successfully!');
    }

    public function edit($subjectId)
    {
        // Retrieve the subject from the database based on the subject ID
        $subject = Subject::findOrFail($subjectId);

        // Pass the subject to the view for editing
        return view('professor.subjects.edit', compact('subject'));
    }

    public function enrollees($subjectId)
    {
        // Retrieve the subject from the database based on the subject ID
        $subject = Subject::findOrFail($subjectId);

        // Retrieve the enrollments for the subject
        $enrollments = Enrolled::where('subject_id', $subject->id)->get();

        // Retrieve the students associated with the enrollments
        $students = User::whereIn('id', $enrollments->pluck('student_id'))->get();

        // Pass the subject, enrollments, and students to the view for display
        return view('professor.subjects.subjects', compact('subject', 'enrollments', 'students'));
    }
    public function update(Request $request, $subjectId)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'course_id' => 'required',
            'course_name' => 'required',
            'slots' => 'required|numeric',
        ]);

        // Find the subject in the database
        $subject = Subject::findOrFail($subjectId);

        // Update the subject with the new data
        $subject->course_id = $request->course_id;
        $subject->course_name = $request->course_name;
        $subject->slots = $request->slots;
        $subject->save();

        // Redirect back to the subjects page with a success message
        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully');
    }
    public function removeEnrollment($subjectId, $enrollmentId)
    {
        $subject = Subject::findOrFail($subjectId);

        // Check if the authenticated professor is the owner of the subject
        if ($subject->prof_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to remove enrolled students for this subject.');
        }

        $enrollment = Enrolled::findOrFail($enrollmentId);
        $enrollment->delete();

        // Increment the slot count by 1
        $subject->slots += 1;
        $subject->save();

        return redirect()->back()->with('success', 'Enrollment removed successfully.');
    }
    public function countEnrollments(Subject $subject)
    {
        return $subject->enrollments()->count();
    }

        
}