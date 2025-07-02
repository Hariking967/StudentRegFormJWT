<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function create()
    {
        $student = Student::where(
            'officialemail',
            Auth::guard('api')->user()->email
        )->first();
        if ($student) {
            return redirect("/students/{$student->rollno}")->with('success', 'Student exists!');
        }
        if (session('success')) {
            return view('student.create')->with('success', 'Logged in successfully');
        }
        return view('student.create');
    }
    public function store()
    {
        $user = Auth::guard('api')->user(); // Use API guard
        $data = request()->validate([
            'rollno' => ['required', 'unique:students,rollno'],
            'name' => ['required'],
            'dob' => ['required', 'date'],
            'email' => ['required', 'email'],
            'contact' => ['required', 'numeric', 'digits:10'],
            'dept' => ['required'],
            'passout' => ['required', 'numeric', 'digits:4']
        ]);

        $data['officialemail'] = $user->email;

        try {
            $student = Student::create($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Student added successfully!',
                'student' => $student
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Contact number or email already exists.'
                ], 422);
            }

            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function index()
    {
        if (Auth::user()->email != 'admin@gmail.com') {
            $student = Student::where('officialemail', Auth::user()->email)->first();
            if (!$student) {
                return redirect('/students/create');
            }
            return redirect("/students/{$student->rollno}");
        }
        $students = Student::latest()->get();
        $n = Student::count();
        return view('student.index', ['students' => $students, 'n' => $n]);
    }
    public function show(Student $student)
    {
        $n = Student::count();
        return view('student.show', ['student' => $student, 'n' => $n]);
    }
    public function edit(Student $student)
    {
        return view('student.edit', ['student' => $student]);
    }
    public function layoutedit()
    {
        $student = Student::where('officialemail', Auth::user()->email)->first();
        return view('student.edit', ['student' => $student]);
    }
    public function update(Student $student)
    {
        $user = Auth::guard('api')->user(); // Use API guard
        $predata = Student::where('officialemail', $student->officialemail)->first();
        $data = request()->validate([
            'rollno' => ['required', Rule::unique('students', 'rollno')->ignore($student->id)],
            'name' => ['required'],
            'dob' => ['required', 'date'],
            'email' => ['required', 'email', Rule::unique('students', 'email')->ignore($student->id)],
            'contact' => ['required', Rule::unique('students', 'contact')->ignore($student->id), 'numeric', 'digits:10'],
            'dept' => ['required'],
            'passout' => ['required', 'numeric', 'digits:4']
        ]);

        $data['officialemail'] = $predata->officialemail;

        try {
            $student->update($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Student updated successfully!',
                'student' => $student
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Contact number or email already exists.'
                ], 422);
            }

            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred while updating.'
            ], 500);
        }
    }


    public function destroy(Student $student)
    {
        $user = Auth::guard('api')->user(); // Use API guard
        $student->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Student deleted successfully!'
        ]);
    }
}
