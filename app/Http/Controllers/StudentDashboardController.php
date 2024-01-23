<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Subject;
use App\Models\Enrolled;
use App\Models\Cart;
use Illuminate\Support\Facades\DB; 
class StudentDashboardController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        $cartSubjects = $this->getCartSubjects();

        return view('student.dashboard', compact('subjects', 'cartSubjects'));
    }

    public function searchSubjects(Request $request)
    {
        $search = $request->input('search');
        $cartSubjects = $this->getCartSubjects();

        $subjects = Subject::whereRaw('LOWER(course_name) LIKE ?', ['%' . strtolower($search) . '%'])
            ->orWhere('course_id', 'ILIKE', "%$search%")
            ->get();

        return view('student.subjects', compact('subjects', 'search', 'cartSubjects'));
    }


    public function checkout()
{
    $cartSubjects = $this->getCartSubjects();

    if ($this->hasReachedMaxEnrollments()) {
        return redirect()->back()->with('error', 'You have reached the maximum number of enrollments.');
    }

    if ($cartSubjects->isEmpty()) {
        return redirect()->back()->with('error', 'No subjects in the cart.');
    }

    $enrollments = [];
    $unavailableSubjects = [];

    foreach ($cartSubjects as $subject) {
        if ($subject->slots > 0 && !$this->isSubjectCheckedOut($subject)) {
            $subjectModel = Subject::findOrFail($subject->id);
            $professorId = $subjectModel->prof_id;

            if ($professorId === null) {
                $unavailableSubjects[] = $subject;
                continue;
            }

            $enrollment = new Enrolled();
            $enrollment->student_id = Auth::id();
            $enrollment->subject_id = $subject->id;
            $enrollment->prof_id = $professorId;
            $enrollment->save();

            $subjectModel->decrement('slots');

            $enrollments[] = $enrollment;

            $this->removeSubjectFromCart($subject);
        } else {
            $unavailableSubjects[] = $subject;
        }
    }

    if (count($enrollments) > 0) {
        if (!empty($unavailableSubjects)) {
            return redirect()->route('student.enrollment.summary')->with('enrollments', $enrollments)->with('unavailableSubjects', $unavailableSubjects);
        } else {
            return view('student.enrollment_summary', compact('enrollments'));
        }
    } else {
        return redirect()->back()->with('error', 'No subjects in the cart can be checked out.')->with('cartSubjects', $cartSubjects);
    }
}


    private function isSubjectCheckedOut($subject)
    {
        return Enrolled::where('student_id', Auth::id())
            ->where('subject_id', $subject->id)
            ->exists();
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
        Session::put('cart', $cartSubjects);
    }

    private function removeSubjectFromCart($subject)
    {
        $cartSubjects = $this->getCartSubjects();
        $cartSubjects->forget($subject->id);
        Session::put('cart', $cartSubjects);
    
        // Remove the subject from the database
        $cart = Cart::where('student_id', Auth::id())->first();
        if ($cart) {
            $subjectIds = $cartSubjects->pluck('id')->toArray();
            $cart->subject_id = $subjectIds;
            $cart->save();
        }
    }
    

    
    private function clearCart()
    {
        Session::forget('cart');
    }

    private function hasReachedMaxEnrollments()
    {
        $maxEnrollments = 15;
        $enrollmentsCount = Enrolled::where('student_id', Auth::id())->count();

        return $enrollmentsCount >= $maxEnrollments;
    }
    public function enrollmentSummary()
    {
        $enrollments = Enrolled::where('student_id', Auth::id())->get();

        return view('student.enrollment_summary', compact('enrollments'));
    }
    
    public function viewSubjects()
    {
        $subjects = Subject::all();
        $cartSubjects = $this->getCartSubjects();

        return view('student.subjects', compact('subjects', 'cartSubjects'));
    }
    public function viewCart()
    {
        $cartSubjects = $this->getCartSubjects();

        return view('student.cart', compact('cartSubjects'));
    }

    public function removeFromCart($subjectId)
    {
        $subject = Subject::findOrFail($subjectId);

        $this->removeSubjectFromCart($subject);

        return redirect()->back()->with('success', 'Subject removed from the cart.');
    }

    public function addToCart($subjectId)
    {
        $subject = Subject::findOrFail($subjectId);
    
        if ($this->isSubjectInCart($subject)) {
            return redirect()->back()->with('error', 'Subject is already in the cart.');
        }
    
        if ($this->isSubjectCheckedOut($subject)) {
            return redirect()->back()->with('error', 'Subject has already been checked out.');
        }
    
        if ($this->hasReachedMaxEnrollments()) {
            return redirect()->back()->with('error', 'You have reached the maximum number of enrollments.');
        }
    
        $subject->load('professor'); // Load the professor relationship
    
        $this->addSubjectToCart($subject);
    
        // Save the cart subjects to the database
        $cartSubjects = $this->getCartSubjects();
        $subjectIds = $cartSubjects->pluck('id')->toArray();
    
        $studentId = Auth::id();
    
        $cart = Cart::where('student_id', $studentId)->first();
        if ($cart) {
            $cart->subject_id = $subjectIds; // Store the subject IDs as a JSON array
            $cart->save();
        } else {
            Cart::create([
                'student_id' => $studentId,
                'subject_id' => $subjectIds,
            ]);
        }
    
        return redirect()->back()->with('success', 'Subject added to the cart.');
    }
    
    
private function getCartSubjects()
{
    $cartSubjects = Session::get('cart', null);

    if ($cartSubjects === null) {
        $studentId = Auth::id();
        $cart = Cart::where('student_id', $studentId)->first();

        if ($cart) {
            $subjectIds = $cart->subject_id;
            $cartSubjects = Subject::whereIn('id', $subjectIds)->with('professor')->get()->keyBy('id');
        } else {
            $cartSubjects = collect();
        }

        Session::put('cart', $cartSubjects);
    }

    return $cartSubjects;
}






  
}
