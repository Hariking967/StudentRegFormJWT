<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function getMyStudent()
    {
        $user = Auth::guard('api')->user();
        $student = Student::where('officialemail', $user->email)->first();

        if (!$student) {
            return response()->json(['status' => 'not_found'], 404);
        }

        return response()->json(['status' => 'found', 'student' => $student]);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        $data = $request->validate([
            'rollno' => ['required', 'unique:students,rollno'],
            'name'   => ['required'],
            'dob'    => ['required', 'date'],
            'email'  => ['required', 'email'],
            'contact' => ['required', 'digits:10'],
            'dept'   => ['required'],
            'passout' => ['required', 'digits:4'],
        ]);
        $data['officialemail'] = $user->email;
        Student::create($data);
        return response()->json(['status' => 'success', 'student' => $data]);
    }

    public function update(Request $request, $rollno)
    {
        $student = Student::where('rollno', $rollno)->firstOrFail();
        $data = $request->validate([
            'rollno' => ['required', Rule::unique('students')->ignore($student->id)],
            'name'   => ['required'],
            'dob'    => ['required', 'date'],
            'email'  => ['required', 'email'],
            'contact' => ['required', 'digits:10'],
            'dept'   => ['required'],
            'passout' => ['required', 'digits:4'],
        ]);
        $student->update($data);
        return response()->json(['status' => 'updated', 'student' => $data]);
    }

    public function destroy($rollno)
    {
        $student = Student::where('rollno', $rollno)->firstOrFail();
        $student->delete();
        return response()->json(['status' => 'deleted']);
    }
}
