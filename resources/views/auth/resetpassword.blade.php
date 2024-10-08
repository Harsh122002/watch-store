@extends('layouts.app')

@section('content')
    <div class="container" style="margin-bottom: 0px;padding-bottom: 100px;margin-top:180px ">
        <h2 class="text-white">Reset Password</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="text-black">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('resetpassword.update') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="text-white">Email Address</label>
                <input type="email" name="email" id="email" class="form-control bg-dark text-white" required>
            </div>

            <div class="form-group">
                <label for="password" class="text-white">New Password</label>
                <input type="password" name="password" id="password" class="form-control bg-dark text-white" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="text-white">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control bg-dark text-white" required>
            </div>

            <button type="submit" class="btn btn-primary">Reset Password</button>
            <a href="{{ route('login') }}" class="text-white">back</a>
        </form>
    </div>
    <!-- GSAP Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate the form when the page loads
            gsap.from("#resetForm", {
                opacity: 0,
                y: 50,
                duration: 1,
                ease: "power2.out"
            });

            // Animate the heading
            gsap.from("h2", {
                opacity: 0,
                scale: 0.5,
                duration: 0.8,
                ease: "bounce.out"
            });

            // Animate each form group with a slight delay
            gsap.from(".form-group", {
                opacity: 0,
                y: 30,
                stagger: 0.2,
                duration: 1,
                ease: "power2.out"
            });

            // Animate the button
            gsap.from("button", {
                opacity: 0,
                scale: 0.8,
                duration: 1,
                delay: 1,
                ease: "elastic.out(1, 0.5)"
            });
        });
    </script>
@endsection
