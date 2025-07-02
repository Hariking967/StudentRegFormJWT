@extends('layout')

@section('title', 'Student Info')

@section('content')
@if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

@if (session('message'))
    <script>
        alert("{{ session('message') }}");
    </script>
@endif
<div class="min-h-screen flex items-center justify-center bg-gray-800 p-6">
    <div class="bg-white text-blue-600 rounded-lg shadow-md w-full max-w-2xl p-6">
        <h1 class="text-4xl font-bold mb-4 text-center">Student Information</h1>
        <h2 class="text-lg font-semibold text-center mb-6">Total Students Registered: {{ $n }}</h2>

        <div class="space-y-4 text-lg">
            <div><span class="font-semibold">Roll Number:</span> {{ $student->rollno }}</div>
            <div><span class="font-semibold">Name:</span> {{ $student->name }}</div>
            <div><span class="font-semibold">Date of Birth:</span> {{ $student->dob }}</div>
            <div><span class="font-semibold">Personal Email:</span> {{ $student->email }}</div>
            <div><span class="font-semibold">Contact:</span> {{ $student->contact }}</div>
            <div><span class="font-semibold">Department:</span> {{ $student->dept }}</div>
            <div><span class="font-semibold">Passout Year:</span> {{ $student->passout }}</div>
        </div>

        <div class="mt-8 flex justify-end gap-4">
            <a href="/students/{{ $student->rollno }}/edit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded transition duration-200">
                Edit
            </a>

            <form id="deleteform" onsubmit="return confirm('Are you sure you want to delete this student?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded transition duration-200">
                    Delete
                </button>
            </form>
            <script>
                const rollno = {{ $student->rollno }};
                document.getElementById('editform').addEventListener('submit',async function(e){
                    e.preventDefault();
                    const rollno = "{{ $student->rollno }}";
                    const res = await fetch('/api/student/${rollno}',{
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        }
                    });
                    if (res.ok)
                    {
                        window.location.href = '/students/create';
                    }
                })
            </script>
        </div>
    </div>
</div>
@endsection
