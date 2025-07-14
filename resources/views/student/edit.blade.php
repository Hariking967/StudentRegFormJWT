@extends('layout')
@section('title','Edit Student')
@section('content')
<script>
document.addEventListener("DOMContentLoaded", function () {
  if (!localStorage.getItem('token')) {
    alert('Please login first!');
    window.location.href = '/login';
    return;
  }

  const params = new URLSearchParams(window.location.search);
  const preroll = params.get('rollno');

  async function loadStudent() {
    try {
      const res = await apiFetch('/student');
      if (!res.ok) throw new Error("Failed to fetch student data");

      const json = await res.json();
      const s = json.student;

      document.getElementById('rollno').value = s.rollno;
      document.getElementById('name').value = s.name;
      document.getElementById('dob').value = s.dob;
      document.getElementById('email').value = s.email;
      document.getElementById('contact').value = s.contact;
      document.getElementById('dept').value = s.dept;
      document.getElementById('passout').value = s.passout;
    } catch (err) {
      console.error("Error while loading student:", err);
      alert("An error occurred while loading student details.");
    }
  }

  loadStudent();

  document.getElementById('editForm').addEventListener('submit', async e => {
    e.preventDefault();
    try {
      const res = await apiFetch(`/students/${preroll}`, {
        method: 'PATCH',
        body: JSON.stringify({
          rollno: document.getElementById('rollno').value,
          name: document.getElementById('name').value,
          dob: document.getElementById('dob').value,
          email: document.getElementById('email').value,
          contact: document.getElementById('contact').value,
          dept: document.getElementById('dept').value,
          passout: document.getElementById('passout').value
        })
      });

      if (res.ok) {
        window.location.href = "/students/show";
      } else {
        console.error("Update failed:", await res.text());
        alert("Could not update student.");
      }
    } catch (err) {
      console.error("Error while updating student:", err);
      alert("An unexpected error occurred.");
    }
  });
});
</script>

<div class="flex min-h-screen items-center justify-center bg-gray-800">
  <form id="editForm" class="bg-gray-800 p-8 rounded shadow-md w-full max-w-md">
    <h1 class="text-3xl text-blue-600 text-center mb-6">Edit Student</h1>
    @csrf
    @method('PATCH')
    <label>Roll Number</label>
    <input id="rollno" class="w-full mb-2 p-2 bg-white text-black">
    <label>Name</label>
    <input id="name" class="w-full mb-2 p-2 bg-white text-black">
    <label>DOB</label>
    <input id="dob" type="date" class="w-full mb-2 p-2 bg-white text-black">
    <label>Email</label>
    <input id="email" type="email" class="w-full mb-2 p-2 bg-white text-black">
    <label>Contact</label>
    <input id="contact" class="w-full mb-2 p-2 bg-white text-black">
    <label>Dept</label>
    <select id="dept" class="w-full mb-2 p-2 bg-white text-black">
      <option value="">--Select--</option>
      <option>CSE</option>
      <option>ECE</option>
      <option>MECH</option>
      <option>CHEM</option>
      <option>CIVIL</option>
    </select>
    <label>Passout</label>
    <input id="passout" type="number" class="w-full mb-6 p-2 bg-white text-black">
    <button type="submit" class="w-full bg-blue-600 py-2 rounded">Update</button>
  </form>
</div>
@endsection
