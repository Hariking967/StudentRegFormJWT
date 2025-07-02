{{-- <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gray-800 text-white">
        <header>
            <div class="fixed top-0 left-0 right-0 flex flex-row justify-between bg-white text-black pt-3 pb-3">
                <div>
                    <a href='/students/create' class='text-2xl text-black hover:bg-gray-600 px-5 py-3 rounded transition duration-200 cursor-pointer'>
                        Dashboard
                    </a>
                    <a href='/students/edit' class='text-2xl text-black hover:bg-gray-600 px-5 py-3 rounded transition duration-200 cursor-pointer'>
                        Form
                    </a>
                </div>
                <div>
                    @guest
                        <a href='/register' class='mr-2 text-2xl text-white bg-blue-600 hover:bg-blue-400 px-5 py-3 rounded transition duration-200 cursor-pointer'>
                            Sign UP
                        </a>
                        <a href='/login' class='mr-2 text-2xl text-white bg-green-600 hover:bg-green-400 px-5 py-3 rounded transition duration-200 cursor-pointer'>
                            Sign IN
                        </a>
                    @endguest
                    @auth
                        <div class='flex flex-row mr-3 items-center justify-center'>
                            <span class="mr-3 text-blue-600 font-bold text-2xl">Welcome {{ Auth::user()->name }}!</span>
                            <form action="/logout" method="POST">
                                @csrf
                                <button type='submit' class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-500">Logout</button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </header>
        <div class="pt-32">
            @yield('content')
        </div>
    </body>
</html> --}}

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gray-800 text-white">
    <header class="fixed top-0 left-0 right-0 bg-white flex justify-between p-3">
        <div>
            <a href='/students/show' class='px-5 py-3 hover:bg-gray-600 rounded text-black'>Dashboard</a>
            <a href='/students/edit' class='px-5 py-3 hover:bg-gray-600 rounded text-black'>Form</a>
        </div>
        <div>
            <div id="auth-buttons" class="flex items-center justify-end space-x-2 pr-6">
    <!-- Dynamic content will be inserted here -->
</div>

<script>
    document.addEventListener("DOMContentLoaded", async function () {
        const token = localStorage.getItem('token');
        const authDiv = document.getElementById('auth-buttons');

        if (!token) {
            authDiv.innerHTML = `
                <a href='/register' class='text-2xl text-white bg-blue-600 hover:bg-blue-400 px-5 py-3 rounded'>Sign UP</a>
                <a href='/login' class='text-2xl text-white bg-green-600 hover:bg-green-400 px-5 py-3 rounded'>Sign IN</a>
            `;
        } else {
            try {
                const res = await fetch('/api/user', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!res.ok) throw new Error("User fetch failed");

                const data = await res.json();
                const name = data.user.name;

                authDiv.innerHTML = `
                    <span class="mr-3 text-blue-600 font-bold text-2xl">Welcome ${name}!</span>
                    <button onclick="logout()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-500">Logout</button>
                `;
            } catch (err) {
                console.error(err);
                localStorage.removeItem('token');
                window.location.href = '/login';
            }
        }
    });

    function logout() {
        localStorage.removeItem('token');
        window.location.href = '/login';
    }
</script>

        </div>
    </header>
    <div class="pt-32">
        @yield('content')
    </div>
</body>
</html>
