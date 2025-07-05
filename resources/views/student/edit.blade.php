@extends('layout')
@section('title','Edit Student')
@section('content')
<script>
if (!localStorage.getItem('token')) {
  alert('Please login first!');
  window.location.href = '/login';
}
</script>
<div class="flex min-h-screen items-center justify-center bg-gray-800">
  <form id="editForm" class="bg-gray-800 p-8 rounded shadow-md w-full max-w-md">
    <h1 class="text-3xl text-blue-600 text-center mb-6">Edit Student</h1>
    @csrf
    @method('PATCH')
    <label>Roll Number</label><input id="rollno" class="w-full mb-2 p-2 bg-white text-black">
    <label>Name</label><input id="name" class="w-full mb-2 p-2 bg-white text-black">
    <label>DOB</label><input id="dob" type="date" class="w-full mb-2 p-2 bg-white text-black">
    <label>Email</label><input id="email" type="email" class="w-full mb-2 p-2 bg-white text-black">
    <label>Contact</label><input id="contact" class="w-full mb-2 p-2 bg-white text-black">
    <label>Dept</label><select id="dept" class="w-full mb-2 p-2 bg-white text-black"><option value="">--Select--</option><option>CSE</option><option>ECE</option><option>MECH</option><option>CHEM</option><option>CIVIL</option></select>
    <label>Passout</label><input id="passout" type="number" class="w-full mb-6 p-2 bg-white text-black">
    <button type="submit" class="w-full bg-blue-600 py-2 rounded">Update</button>
  </form>
</div>
<script>
const params = new URLSearchParams(window.location.search);
const preroll = params.get('rollno');
async function loadStudent() {
  const token = localStorage.getItem('token');
  const res = await fetch('/api/student', {
    headers: {
      "Authorization": "Bearer " + token,
      "Accept": "application/json"
    }
  });
  if (res.ok) {
    const json = await res.json();
    const s = json.student;
    document.getElementById('rollno').value = s.rollno;
    document.getElementById('name').value = s.name;
    document.getElementById('dob').value = s.dob;
    document.getElementById('email').value = s.email;
    document.getElementById('contact').value = s.contact;
    document.getElementById('dept').value = s.dept;
    document.getElementById('passout').value = s.passout;
  }
}
loadStudent();

document.getElementById('editForm').addEventListener('submit', async e => {
  e.preventDefault();
  const token = localStorage.getItem('token');
  const res = await fetch(`/api/students/${preroll}`, {
    method: 'PATCH',
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
    window.location.href = "/students/show";
  } else alert("Could not update");
});
</script>
@endsection
