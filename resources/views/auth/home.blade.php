<!-- resources/views/pages/product-list.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-end mb-4 mr-4" id="search-bar">
        <form action="{{ route('home') }}" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" class="form-control" name="query" placeholder="Search Products"
                    aria-label="Search Products" aria-describedby="search-button" value="{{ request('query') }}">
                <button class="btn btn-outline-light" type="submit" id="search-button" disabled>Search</button>
                <button class="btn btn-outline-secondary d-none" type="button" id="back-button">Back</button>
            </div>
        </form>
    </div>
    <div class="container" style="min-height: 700px">
        <!-- Search Bar on the right side at the top -->

        <!-- Product List Heading -->
        <div class="product-heading">
            <h1 class="h1 text-white">Product List</h1>
        </div>

        <!-- Product List -->
        <div class="row">
            @if ($products->isEmpty())
                <div class="col-12">
                    <p class="text-white">Product Not Found</p>
                </div>
            @else
                @foreach ($products as $product)
                    <div class="col-12 mb-4 product">
                        <div class="row g-0 align-items-center">
                            <!-- Product Image -->
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid product-image"
                                    alt="{{ $product->name }}">
                            </div>

                            <!-- Product Details -->
                            <div class="col-md-8">
                                <div class="text-white product-details">
                                    <h5>{{ $product->name }}</h5>
                                    <p>Price: Rs.{{ $product->price }}</p>
                                    <p>Description: {{ $product->description }}</p>
                                    <p>Warranty: {{ $product->warranty }}</p>
                                    @if ($product->quantity > 0)
                                        <p>{{ $product->quantity }} in stock</p>
                                    @else
                                        <p class="text-danger">Out of Stock</p>
                                    @endif
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                        @csrf
                                        <!-- Quantity Input with + and - buttons -->
                                        <div class="mb-3 d-flex align-items-center">
                                            <label for="quantity{{ $product->id }}" class="form-label me-2"
                                                style="margin-right: 20px; font-size: 25px">
                                                Quantity:
                                            </label>

                                            <div class="input-group quantity-wrapper" style="width: 140px;">
                                                <button class="btn btn-outline-secondary decrement-btn" type="button"
                                                    id="decrement{{ $product->id }}"
                                                    data-id="{{ $product->id }}">-</button>
                                                <input type="number" class="form-control text-white quantity-input"
                                                    style="padding-left: 20px;" id="quantity{{ $product->id }}"
                                                    name="quantity" min="1" max="4" value="1" readonly>
                                                <button class="btn btn-outline-secondary increment-btn" type="button"
                                                    id="increment{{ $product->id }}"
                                                    data-id="{{ $product->id }}">+</button>
                                            </div>
                                        </div>

                                        <!-- Add to Cart Button -->
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-primary mt-2">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Pagination Controls -->
        <div class="d-flex justify-content-center mt-4 text-white">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Retrieve query parameter from URL
            const urlParams = new URLSearchParams(window.location.search);
            const query = urlParams.get('query'); // Get the value of 'query' parameter
            console.log(query);

            const queryInput = document.querySelector('input[name="query"]');
            const searchButton = document.getElementById('search-button');
            const backButton = document.getElementById('back-button');

            // Set the input value based on the query parameter
            if (query) {
                queryInput.value = query;
                searchButton.disabled = false; // Enable the search button if there's a query
                backButton.classList.remove('d-none'); // Show the back button
            } else {
                searchButton.disabled = true; // Disable the search button if no query
                backButton.classList.add('d-none'); // Hide the back button
            }

            // Event listener for input changes
            queryInput.addEventListener('input', function() {
                if (queryInput.value.trim()) {
                    searchButton.disabled = false; // Enable search button
                    backButton.classList.remove('d-none'); // Show back button
                } else {
                    searchButton.disabled = true; // Disable search button
                    backButton.classList.add('d-none'); // Hide back button
                }
            });

            // Event listener for the back button
            backButton.addEventListener('click', function() {
                // Clear the query input and submit the form
                queryInput.value = '';
                searchButton.click(); // Submit the form by triggering the search button's click
            });

            document.querySelectorAll(".quantity-wrapper").forEach((wrapper) => {
                let quantityInput = wrapper.querySelector(".quantity-input");
                let incrementBtn = wrapper.querySelector(".increment-btn");
                let decrementBtn = wrapper.querySelector(".decrement-btn");

                if (quantityInput && incrementBtn && decrementBtn) {
                    incrementBtn.addEventListener("click", function() {
                        let currentValue = parseInt(quantityInput.value);
                        const max = parseInt(quantityInput.getAttribute("max"));

                        if (currentValue < max) {
                            quantityInput.value = currentValue + 1;
                        }
                    });

                    decrementBtn.addEventListener("click", function() {
                        let currentValue = parseInt(quantityInput.value);
                        const min = parseInt(quantityInput.getAttribute("min"));

                        if (currentValue > min) {
                            quantityInput.value = currentValue - 1;
                        }
                    });
                }
            });
        });
    </script>

@endsection
