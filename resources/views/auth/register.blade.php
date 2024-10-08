@extends('layouts.app')

@section('content')
    <div class="container text-white" style="margin-bottom: 0px;padding-bottom: 40px;margin-top:60px ">
        <!-- Added text-white to the container -->
        <h2 class="mb-4 text-white">Register</h2> <!-- White title -->

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-black">{{ $error }}</li> <!-- White text for errors -->
                    @endforeach
                </ul>
            </div>
        @elseif (session('success'))
            <div class="alert alert-success">
                {{ session('success') }} <!-- Default success alert -->
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name" class="text-white">Name</label> <!-- Changed label color to white -->
                <input type="text" name="name" id="name" class="form-control bg-dark text-white" required>
            </div>

            <div class="form-group mb-3">
                <label for="email" class="text-white">Email Address</label>
                <input type="email" name="email" id="email" class="form-control bg-dark text-white" required>
            </div>

            <div class="form-group mb-3">
                <label for="password" class="text-white">Password</label>
                <input type="password" name="password" id="password" class="form-control bg-dark text-white" required>
            </div>

            <div class="form-group mb-3">
                <label for="phone" class="text-white">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control bg-dark text-white" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <div class="mt-3">
            <p class="text-white">Already have an account? <a href="{{ route('login') }}" class="text-danger">Login
                    here</a></p>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate the form when the page loads
            gsap.from("#registerForm", {
                opacity: 0,
                y: 50,
                duration: 1.2,
                ease: "power2.out"
            });

            // Animate the heading
            gsap.from("h2", {
                opacity: 0,
                y: -30,
                duration: 1,
                ease: "bounce.out"
            });

            // Animate each form group with a staggered effect
            gsap.from(".form-group", {
                opacity: 0,
                y: 20,
                stagger: 0.2,
                duration: 1,
                ease: "power2.out"
            });

            // Animate the button
            gsap.from("button", {
                opacity: 0,
                scale: 0.8,
                duration: 1,
                delay: 1.5,
                ease: "elastic.out(1, 0.5)"
            });

            // Animate the link at the bottom
            gsap.from(".mt-3", {
                opacity: 0,
                y: 20,
                duration: 1,
                delay: 2,
                ease: "power2.out"
            });
        });
    </script>
@endsection
