@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <h1 class="text-center text-white">Order Form</h1>

        @if ($errors->has('field_name'))
            <div class="alert alert-danger">
                {{ $errors->first('field_name') }}
            </div>
        @endif

        <form id="order-form" action="{{ route('order.submit') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label text-white">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-white">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label text-white">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address"
                    required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label text-white">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}"
                    placeholder="Enter your phone number" required>
            </div>

            <div class="mb-3">
                <label for="order-id" class="form-label text-white">Order ID</label>
                <input type="text" class="form-control" id="order-id" name="order_id" readonly>
            </div>
            <div class="table-responsive"> <!-- Responsive wrapper -->

                <table class="table text-white">
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        style="width: 100px; height: auto;">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>Rs.{{ $product->price }}</td>
                                <td>{{ $cart[$product->id] }} Nos </td>
                                <td>Rs.{{ $product->price * $cart[$product->id] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end text-white">Total</td>
                            <td class="text-white">Rs.{{ $total }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end text-white">SGST (5%)</td>
                            <td class="text-white">Rs.{{ $sgst }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end text-white">CGST (5%)</td>
                            <td class="text-white">Rs.{{ $cgst }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end text-white">Delivery ({{ $total > 150 ? 0 : 50 }})</td>
                            <td class="text-white">Rs.{{ $delivery }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end text-white">Grand Total</td>
                            <td class="text-white">Rs.{{ $orderTotal }}</td>
                        </tr>
                    </tfoot>
                </table>

                <div class="mb-3">
                    <label class="form-label text-white">Payment Type</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_type" id="payment-cash" value="cash">
                        <label class="form-check-label text-white" for="payment-cash">Cash</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_type" id="payment-online"
                            value="online">
                        <label class="form-check-label text-white" for="payment-online">Online</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mb-2" id="submit-btn" disabled>Submit Order</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>

            </div>
        </form>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>

    <script>
        function generateOrderId() {
            const orderId = Math.floor(10000000 + Math.random() * 90000000);
            document.getElementById('order-id').value = orderId;
        }

        function enableSubmitButton() {
            const paymentType = document.querySelector('input[name="payment_type"]:checked');
            const submitButton = document.getElementById('submit-btn');
            submitButton.disabled = !paymentType;
        }

        window.onload = function() {
            generateOrderId();
            const paymentRadios = document.querySelectorAll('input[name="payment_type"]');
            paymentRadios.forEach(radio => radio.addEventListener('change', enableSubmitButton));

            gsap.from("#order-form", {
                opacity: 0,
                y: 50,
                duration: 1
            });
            gsap.from("input, select, textarea, button", {
                opacity: 0,
                y: 20,
                stagger: 0.1,
                duration: 1
            });
        };

        document.getElementById('order-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const paymentType = document.querySelector('input[name="payment_type"]:checked').value;

            if (paymentType === 'online') {
                const options = {
                    "key": "{{ env('RAZORPAY_KEY_ID') }}",
                    "amount": "{{ $orderTotal * 100 }}",
                    "currency": "INR",
                    "name": "Watch Store",
                    "description": "Order Payment",
                    "image": "{{ asset('images/logo.png') }}",
                    "handler": function(response) {
                        const form = document.getElementById('order-form');
                        form.appendChild(createHiddenInput('razorpay_payment_id', response
                            .razorpay_payment_id));
                        form.appendChild(createHiddenInput('razorpay_order_id', response
                            .razorpay_order_id));
                        form.appendChild(createHiddenInput('razorpay_signature', response
                            .razorpay_signature));
                        form.submit();
                    },
                    "prefill": {
                        "name": "{{ Auth::user()->name }}",
                        "email": "{{ Auth::user()->email }}",
                        "contact": "{{ Auth::user()->phone }}"
                    },
                    "theme": {
                        "color": "#3399cc"
                    }
                };

                var rzp1 = new Razorpay(options);
                rzp1.open();
            } else {
                document.getElementById('order-form').submit();
            }
        });

        function createHiddenInput(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            return input;
        }
    </script>
@endsection
