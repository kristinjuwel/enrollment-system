<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfessorDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\EnrollmentController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\SubjectController;





// Login Route
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Register Route
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');



// Professor Dashboard

// Dashboard
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');





Route::prefix('professor')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProfessorDashboardController::class, 'index'])->name('professor.dashboard');
    Route::get('/professor/profile', [ProfessorDashboardController::class, 'profile'])->name('professor.profile');
    Route::get('/professor/profile/edit', [ProfessorDashboardController::class, 'editProfile'])->name('professor.profile.edit');
    Route::post('/professor/profile/update', [ProfessorDashboardController::class, 'updateProfile'])->name('professor.profile.update');
    Route::post('/subject/create', [ProfessorDashboardController::class, 'createSubject'])->name('subject.create');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subject/{subjectId}/enrolled-students', [ProfessorDashboardController::class, 'viewEnrolledStudents'])->name('enrollment.view');
    Route::delete('/subject/{subjectId}/enrolled-students/{enrollmentId}', [ProfessorDashboardController::class, 'removeEnrollment'])->name('enrollment.remove');
    Route::get('/subjects/{subjectId}/enrollees', [SubjectController::class, 'enrollees'])->name('subject.enrollees');
    Route::get('/subjects/{subjectId}/edit', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::put('/subjects/{subjectId}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/enrollment/remove/{subjectId}/{enrollmentId}', [SubjectController::class, 'removeEnrollment'])->name('enrollment.remove');


});


// Student Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/student/dashboard/search', [StudentDashboardController::class, 'searchSubjects'])->name('student.search');
    Route::post('/student/dashboard/cart/add/{subject}', [StudentDashboardController::class, 'addToCart'])->name('student.cart.add');
    Route::delete('/student/dashboard/cart/remove/{subject}', [StudentDashboardController::class, 'removeFromCart'])->name('student.cart.remove');
    Route::post('/cart/checkout', [StudentDashboardController::class, 'checkout'])->name('student.cart.checkout');
    Route::get('student/enrollment/summary', [StudentDashboardController::class, 'enrollmentSummary'])->name('student.enrollment.summary');
    Route::get('/enrollment/summary/total', [EnrollmentController::class, 'totalSummary'])->name('student.enrollment.summary.total');
    Route::get('/student/subjects', [StudentDashboardController::class, 'viewSubjects'])->name('student.subjects');
    Route::get('/student/cart', [StudentDashboardController::class, 'viewCart'])->name('student.cart');
    Route::get('/student/profile/edit', [RegisterController::class, 'editProfile'])->name('student.profile.edit');
    Route::post('profile/update', [RegisterController::class, 'updateProfile'])->name('student.profile.update');

});



Route::get('/', function () {
    return view('welcome');
});

