@extends('layout')
@section('title','Register Student')
@section('content')
<script>
if (!localStorage.getItem('token')) {
  alert('Please login first!');
  window.location.href = '/login';
}
</script>
<div class="flex min-h-screen items-center justify-center bg-gray-800">
  <form id="createForm" class="bg-gray-800 p-8 rounded shadow-md w-full max-w-md">
    <h1 class="text-3xl text-blue-600 text-center mb-6">Student Registration</h1>
    @csrf
    <label>Roll Number</label><input id="rollno" class="w-full mb-2 p-2 bg-white text-black">
    <label>Name</label><input id="name" class="w-full mb-2 p-2 bg-white text-black">
    <label>DOB</label><input id="dob" type="date" class="w-full mb-2 p-2 bg-white text-black">
    <label>Email</label><input id="email" type="email" class="w-full mb-2 p-2 bg-white text-black">
    <label>Contact</label><input id="contact" class="w-full mb-2 p-2 bg-white text-black">
    <label>Dept</label><select id="dept" class="w-full mb-2 p-2 bg-white text-black"><option value="">--Select--</option><option>CSE</option><option>ECE</option><option>MECH</option><option>CHEM</option><option>CIVIL</option></select>
    <label>Passout</label><input id="passout" type="number" class="w-full mb-6 p-2 bg-white text-black">
    <button type="submit" class="w-full bg-blue-600 py-2 rounded">Submit</button>
  </form>
</div>
<script>
// import { apiFetch } from '/js/api.js';
document.getElementById('createForm').addEventListener('submit', async e => {
  e.preventDefault();
  const token = localStorage.getItem('token');
  const res = await apiFetch("/students", {
    method: "POST",
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
  const data = await res.json();

if (res.ok) {
  window.location.href = `/students/show`;
} else {
  console.error("Student creation failed:", data);
  alert(data.message || JSON.stringify(data.errors) || "Could not create student");
}

});
</script>
@endsection
