<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\Subject; // Import the Subject model
use App\Models\Enrolled;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Check if the authenticated user is a professor
        if (Auth::user()->role === 'professor') {
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
        $subjects = Subject::all(); // Get all subjects
        $cartSubjects = $this->getCartSubjects();
    
        $subjects = collect($subjects); // Convert to collection
    
        return view('student.dashboard', compact('subjects', 'cartSubjects'));
    }


    public function searchSubjects(Request $request)
    {
        $search = $request->input('search');
        $cartSubjects = $this->getCartSubjects();

        // Search for subjects based on the course name or course ID (case-insensitive)
        $subjects = Subject::whereRaw('LOWER(course_name) LIKE ?', ['%'.strtolower($search).'%'])
            ->orWhere('course_id', 'ILIKE', "%$search%")
            ->get();

        return view('student.dashboard', compact('subjects', 'search', 'cartSubjects'));
    }


    public function addToCart($subjectId)
    {
        // Retrieve the subject
        $subject = Subject::findOrFail($subjectId);

        // Check if the subject is already in the cart
        if ($this->isSubjectInCart($subject)) {
            return redirect()->back()->with('error', 'Subject is already in the cart.');
        }

        // Check if the student has already enrolled in the maximum number of subjects
        if ($this->hasReachedMaxEnrollments()) {
            return redirect()->back()->with('error', 'You have reached the maximum number of enrollments.');
        }

        // Add the subject to the cart
        $this->addSubjectToCart($subject);

        // Retrieve the updated cart subjects
        $cartSubjects = $this->getCartSubjects();

        return redirect()->back()->with('success', 'Subject added to the cart.')->with(compact('cartSubjects'));
    }

    public function removeFromCart($subjectId)
    {
        // Retrieve the subject
        $subject = Subject::findOrFail($subjectId);

        // Remove the subject from the cart
        $this->removeSubjectFromCart($subject);

        // Retrieve the updated cart subjects
        $cartSubjects = $this->getCartSubjects();

        return redirect()->back()->with('success', 'Subject removed from the cart.')->with(compact('cartSubjects'));
    }


    public function checkout()
    {
        // Retrieve the subjects in the cart
        $cartSubjects = $this->getCartSubjects();

        // Check if the student has already enrolled in the maximum number of subjects
        if ($this->hasReachedMaxEnrollments()) {
            return redirect()->back()->with('error', 'You have reached the maximum number of enrollments.');
        }

        // Check if there are subjects in the cart
        if ($cartSubjects->isEmpty()) {
            return redirect()->back()->with('error', 'No subjects in the cart.');
        }

        // Enroll the student in the subjects
        $enrollments = [];
        foreach ($cartSubjects as $subject) {
            // Check if the subject still has available slots
            if ($subject->slots > 0) {
                // Create the enrollment record
                $enrollment = new Enrolled();
                $enrollment->student_id = Auth::id();
                $enrollment->subject_id = $subject->id;
                $enrollment->prof_id = $subject->prof_id; // Set the prof_id value
                $enrollment->save();

                // Decrement the available slots for the subject
                $subject->decrement('slots');

                // Add the enrollment to the list
                $enrollments[] = $enrollment;
            }
        }

        // Clear the cart
        $this->clearCart();

        return view('student.enrollment_summary', compact('enrollments'));
    }


        
    private function isSubjectInCart($subject)
    {
        $cartSubjects = $this->getCartSubjects();

        return $cartSubjects->contains('id', $subject->id);
    }

    private function addSubjectToCart($subject)
    {
        $cartSubjects = $this->getCartSubjects();
        $cartSubjects->put($subject->id, $subject);
        session(['cart' => $cartSubjects]);
    }

    private function removeSubjectFromCart($subject)
    {
        $cartSubjects = $this->getCartSubjects();
        $cartSubjects->forget($subject->id);
        session(['cart' => $cartSubjects]);
    }

        private function getCartSubjects()
    {
        return session('cart', collect());
    }

    private function clearCart()
    {
        session()->forget('cart');
    }

    private function hasReachedMaxEnrollments()
        {
            $maxEnrollments = 5; // Set the maximum number of enrollments
            $enrollmentsCount = Enrolled::where('student_id', Auth::id())->count();

            return $enrollmentsCount >= $maxEnrollments;
        }
    
    public function createSubject(Request $request)
{
    $validatedData = $request->validate([
        'course_code' => 'required',
        'course_name' => 'required',
        'slots' => 'required|integer',
    ]);

    $subject = new Subject();
    $subject->course_id = Str::uuid()->toString();
    $subject->course_code = $validatedData['course_code'];
    $subject->course_name = $validatedData['course_name'];
    $subject->slots = $validatedData['slots'];
    $subject->prof_id = Auth::id();
    $subject->save();

    return redirect()->route('professor.dashboard')->with('success', 'Subject created successfully.');
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
    
        return redirect()->back()->with('success', 'Enrollment removed successfully.');
    }

}