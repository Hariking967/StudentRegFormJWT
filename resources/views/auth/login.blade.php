@extends('layout')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-800">
    <div class="bg-gray-800 p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold text-green-600 mb-6 text-center">User Login</h1>

        <form id="loginForm">
            @csrf

            <label for="email" class="block text-green-600 mb-1">Official Email</label>
            <input id="email" name="email" type="email"
                   class="w-full mb-1 p-2 border rounded bg-white text-black" placeholder="Email" required>

            <label for="password" class="block text-green-600 mb-1">Password</label>
            <input id="password" name="password" type="password"
                   class="w-full mb-1 p-2 border rounded bg-white text-black" placeholder="Password" required>

            <button type="submit"
                    class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-500 transition duration-200">
                Login
            </button>
        </form>

        <script>
            // import { apiFetch } from '/js/api.js';
            document.getElementById('loginForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                // const res = await fetch("/api/login", {
                //     method: "POST",
                //     headers: {
                //         "Content-Type": "application/json",
                //         "Accept": "application/json"
                //     },
                //     body: JSON.stringify({ email, password })
                // });
                const res = await apiFetch('/login', {
                    method: "POST",
                    body: JSON.stringify({ email, password })
                    });


                const data = await res.json();

                if (res.ok) {
                    localStorage.setItem('token', data.authorisation.token);

                    // const infoRes = await fetch("/api/student", {
                    //     headers: {
                    //         "Accept": "application/json",
                    //         "Authorization": `Bearer ${data.authorisation.token}`
                    //     }
                    // });
                    const infoRes = await apiFetch("/student");

                    if (infoRes.status === 404) {
                        alert("No student info found. Redirecting to create...");
                        window.location.href = "/students/create";
                    } else {
                        alert("Login successful!");
                        window.location.href = "/students/show";
                    }
                } else {
                    alert(data.message || "Login failed");
                }
            });
        </script>
    </div>
</div>
@endsection
