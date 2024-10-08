@extends('layouts.app')

@section('content')
    <div class="container" style="margin-bottom: 0px;padding-bottom: 100px;margin-top:165px ">
        <h2 class="text-white">Login</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="text-black">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email" class="text-white">Email Address</label>
                <input type="email" name="email" id="email" class="form-control bg-dark text-white" required>
            </div>

            <div class="form-group">
                <label for="password" class="text-white">Password</label>
                <input type="password" name="password" id="password" class="form-control bg-dark text-white" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <div class="mt-3">
            <p class="text-white">Don't have an account? <a href="{{ route('register') }}" class="text-danger">Register
                    here</a></p>
            <p><a href="{{ route('resetpassword') }}" class="text-danger">Forgot your password?</a></p>
            <p><a href="{{ route('adminLogin') }}" class="text-danger">Admin</a></p>

        </div>
    </div>
    <!-- GSAP Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate the form when the page loads
            gsap.from("#loginForm", {
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

            // Animate the links at the bottom
            gsap.from(".mt-3 p", {
                opacity: 0,
                y: 20,
                duration: 1,
                delay: 2,
                ease: "power2.out"
            });
        });
    </script>
@endsection
