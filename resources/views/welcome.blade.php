@extends('layout')

@section('title','Welcome')

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

<div class="flex flex-col items-center justify-center min-h-screen text-center">
    <h1 class="text-5xl">
        Welcome to Student Registration!!!
    </h1><br/>
    <h2 class="text-4xl">
        <a href='/login' class="cursor-pointer underline">Sign IN</a> OR 
        <a href='/register' class="cursor-pointer underline">Sign UP</a> to continue!
    </h2>
</div>
@endsection