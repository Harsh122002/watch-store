<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            overflow-x: hidden;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            margin: 10px 0;
            text-decoration: none;
            display: block;
            padding: 10px;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            background-color: #212529;
            color: white;
        }

        .card-title {
            color: #ffc107;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }

            .sidebar {
                min-height: auto;
            }

            .sidebar a {
                padding: 10px 15px;
            }
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" style="padding: 100px">
            <h4 class="text-center text-white mb-3">Admin Panel</h4>
            <a href="{{ route('add-product') }}" id="addProductBtn">Add Product</a>
            <a href="{{ route('products.index') }}" id="addDiscountBtn">Add Discount</a>
            <a href="{{ route('products.pending') }}" id="manageOrderBtn">Manage Orders</a>
            <a href="#" id="userProfileBtn">Profile</a>
            <a href="#" id="logoutBtn">Logout</a>
        </div>

        <!-- Main Content -->
        <div class="content w-100 mt-5">
            <h2>Dashboard</h2>
            <div class="row mt-5">
                <!-- Pending Orders -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <a href="{{ route('products.pending') }}">
                                <h5 class="card-title">Pending Orders</h5>
                                <p class="card-text" id="pendingOrders">{{ $pendingOrdersCount }}</p>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Running Orders -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <a href="{{ route('products.running') }}">
                                <h5 class="card-title">Running Orders</h5>
                                <p class="card-text" id="runningOrders">{{ $runningOrdersCount }}</p>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Completed Orders -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <a href="{{ route('products.complete') }}">
                                <h5 class="card-title">Completed Orders</h5>
                                <p class="card-text" id="completedOrders">{{ $completeOrdersCount }}</p>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <!-- Declined Orders -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <a href="{{ route('products.declined') }}">
                                <h5 class="card-title">Declined Orders</h5>
                                <p class="card-text" id="declinedOrders">{{ $declinedOrdersCount }}</p>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Earnings -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Earnings</h5>
                            <p class="card-text" id="earnings">Rs. {{ $grandTotalSum }}</p>
                        </div>
                    </div>
                </div>

                <!-- Registered Users -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Registered Users</h5>
                            <p class="card-text" id="registeredUsers">{{ $usersCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Returning Orders -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <a href="{{ route('products.pending') }}">
                                <h5 class="card-title">Returning Orders</h5>
                                <p class="card-text" id="returningOrders">{{ $returningOrdersCount }}</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <a href="{{ route('products.returned') }}">
                                <h5 class="card-title">Returned Orders</h5>
                                <p class="card-text" id="returnedOrders">{{ $returnedOrdersCount }}</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <a href="#">
                                <h5 class="card-title">Returned Amount</h5>
                                <p class="card-text" id="returnedGrandTotalSum">Rs.{{ $returnedGrandTotalSum }}</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GSAP Animation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script>
        // GSAP Animation for Card Entrance
        gsap.from(".card", {
            duration: 1,
            opacity: 0,
            y: 50,
            stagger: 0.3
        });

        // GSAP Sidebar Hover Animation
        const links = document.querySelectorAll('.sidebar a');
        links.forEach(link => {
            link.addEventListener('mouseover', () => {
                gsap.to(link, {
                    duration: 0.3,
                    x: 10
                });
            });
            link.addEventListener('mouseout', () => {
                gsap.to(link, {
                    duration: 0.3,
                    x: 0
                });
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
