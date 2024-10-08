@extends('layouts.app')

@section('content')
    <div class="container mt-5 pb-5 text-white">
        <h1 class="text-center mb-4">About Us</h1>

        <div class="row text-white">
            <div class="col-lg-6 mb-4">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid rounded shadow-sm" alt="Watch Store">
            </div>
            <div class="col-lg-6">
                <h2>Welcome to Watch Store</h2>
                <p>
                    At [Your Store Name], we are passionate about watches. Our store offers a curated collection of
                    high-quality timepieces, from classic designs to modern innovations. We pride ourselves on providing
                    excellent customer service and helping you find the perfect watch to suit your style and needs.
                </p>
                <h3>Our Mission</h3>
                <p>
                    Our mission is to be the go-to destination for watch enthusiasts and casual buyers alike. We aim to
                    deliver a personalized shopping experience, knowledgeable advice, and an impressive selection of watches
                    from renowned brands.
                </p>
                <h3>Why Choose Us?</h3>
                <ul>
                    <li>Expertly curated selection of watches</li>
                    <li>Exceptional customer service</li>
                    <li>Competitive pricing and special offers</li>
                    <li>Easy returns and exchanges</li>
                </ul>
                <p>
                    Thank you for visiting our store. We look forward to serving you and helping you find your next favorite
                    timepiece.
                </p>
            </div>
        </div>
    </div>
@endsection
