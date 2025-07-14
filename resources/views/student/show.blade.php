@extends('layout')
@section('title','Student Info')
@section('content')
<script>
if (!localStorage.getItem('token')) {
  alert('Please login first!');
  window.location.href = '/login';
}
</script>
<div class="flex min-h-screen items-center justify-center bg-gray-800">
  <div class="bg-white text-blue-600 rounded-lg shadow p-6 w-full max-w-2xl">
    <h1 class="text-4xl text-center mb-4">Student Info</h1>
    <h2 class="text-2xl text-center mb-4">Total Students Registered: <span id="nstudents" class="space-y-4 text-lg"></span></h2>
    <div id="studentData" class="space-y-4 text-lg"></div>
    <div class="mt-8 flex justify-end gap-4">
      <button id="editBtn" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded">Edit</button>
      <button id="deleteBtn" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded">Delete</button>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  if (!localStorage.getItem('token')) {
    alert('Please login first!');
    window.location.href = '/login';
    return;
  }

  async function loadStudent() {
    try {
      const res = await apiFetch('/student');
      if (!res.ok) throw new Error("Failed to fetch");

      const { student, n } = await res.json();
      const container = document.getElementById('studentData');
      const keys = ['rollno','name','dob','email','contact','dept','passout'];
      keys.forEach(key => {
        const el = document.createElement('div');
        el.innerHTML = `<strong>${key.toUpperCase()}:</strong> ${student[key]}`;
        container.appendChild(el);
      });

      document.getElementById('nstudents').textContent = n;

      document.getElementById('editBtn').onclick = () => {
        window.location.href = '/students/edit?rollno=' + student.rollno;
      };

      document.getElementById('deleteBtn').onclick = async () => {
        if (confirm('Delete?')) {
          const dres = await apiFetch(`/students/${student.rollno}`, {
            method: 'DELETE'
          });
          if (dres.ok) window.location.href = '/students/create';
          else alert("Failed to delete student");
        }
      };
    } catch (err) {
      console.error("Error while loading student:", err);
      alert("An error occurred while fetching student data.");
    }
  }

  loadStudent();
});
</script>

@endsection
