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
    <label>Roll Number</label><input id="rollno" class="w-full mb-2 p-2">
    <label>Name</label><input id="name" class="w-full mb-2 p-2">
    <label>DOB</label><input id="dob" type="date" class="w-full mb-2 p-2">
    <label>Email</label><input id="email" type="email" class="w-full mb-2 p-2">
    <label>Contact</label><input id="contact" class="w-full mb-2 p-2">
    <label>Dept</label><select id="dept" class="w-full mb-2 p-2"><option value="">--Select--</option><option>CSE</option><option>ECE</option></select>
    <label>Passout</label><input id="passout" type="number" class="w-full mb-6 p-2">
    <button type="submit" class="w-full bg-blue-600 py-2 rounded">Submit</button>
  </form>
</div>
<script>
document.getElementById('createForm').addEventListener('submit', async e => {
  e.preventDefault();
  const token = localStorage.getItem('token');
  const res = await fetch("/api/students", {
    method: "POST",
    headers: {
      "Authorization": "Bearer " + token,
      "Content-Type": "application/json",
      "Accept": "application/json"
    },
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
    const data = await res.json();
    window.location.href = `/students/show`;
  } else alert("Could not create student");
});
</script>
@endsection
