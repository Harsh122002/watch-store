@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-white">Profile Details</h2> <!-- Added title with white text -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.reset') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label text-white">Name</label>
                <input type="text" name="name" id="name" class="form-control bg-dark text-white"
                    value="{{ old('name', auth()->user()->name) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label text-white">Address</label>
                <input type="text" name="address" id="address" class="form-control bg-dark text-white"
                    value="{{ old('address', auth()->user()->address) }}">
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-white">Email</label>
                <input type="email" name="email" id="email" class="form-control bg-dark text-white"
                    value="{{ old('email', auth()->user()->email) }}" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label text-white">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control bg-dark text-white"
                    value="{{ old('phone', auth()->user()->phone) }}">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
            <a href="/" class="text-white mt-3 d-inline-block">Back</a>
        </form>
    </div>
@endsection
