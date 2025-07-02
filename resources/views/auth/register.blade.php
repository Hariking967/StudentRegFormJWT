@extends('layout')

@section('title', 'Register')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-800">
        <div class="bg-gray-800 p-8 rounded shadow-md w-full max-w-md">
            <h1 class="text-3xl font-bold text-blue-500 mb-6 text-center">User Registration</h1>

            <form id="registerForm">
                @csrf

                <label for="name" class="block text-blue-500 mb-1">Name</label>
                <input id="name" name="name" type="text"
                       class="w-full mb-2 p-2 border rounded bg-white text-black" placeholder="Your name" required>

                <label for="email" class="block text-blue-500 mb-1">Official Email</label>
                <input id="email" name="email" type="email"
                       class="w-full mb-2 p-2 border rounded bg-white text-black" placeholder="Email" required>

                <label for="password" class="block text-blue-500 mb-1">Password</label>
                <input id="password" name="password" type="password"
                       class="w-full mb-2 p-2 border rounded bg-white text-black" placeholder="Password" required>

                <label for="confirmPassword" class="block text-blue-500 mb-1">Confirm Password</label>
                <input id="confirmPassword" name="confirmPassword" type="password"
                       class="w-full mb-4 p-2 border rounded bg-white text-black" placeholder="Confirm Password" required>

                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-500 transition duration-200">
                    Register
                </button>
            </form>

            <script>
                document.getElementById('registerForm').addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const name = document.getElementById('name').value;
                    const email = document.getElementById('email').value;
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;

                    if (password !== confirmPassword) {
                        alert("Passwords do not match!");
                        return;
                    }

                    const res = await fetch("/api/register", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({ name, email, password })
                    });

                    const data = await res.json();

                    if (res.ok) {
                        localStorage.setItem('token', data.authorisation.token);

                        // Check if student info exists
                        const infoRes = await fetch("/api/student", {
                            headers: {
                                "Accept": "application/json",
                                "Authorization": `Bearer ${data.authorisation.token}`
                            }
                        });

                        if (infoRes.status === 404) {
                            alert("No student info found. Redirecting to create...");
                            window.location.href = "/students/create";
                        } else {
                            alert("Registration successful!");
                            window.location.href = "/students/show";
                        }
                    } else {
                        alert(data.message || "Registration failed");
                    }
                });
            </script>
        </div>
    </div>
@endsection
