<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Add Product</h2>

        <!-- Success message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('add-product-store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="name"
                    placeholder="Enter product name" required>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity"
                    required>
            </div>

            <div class="mb-3">
                <label for="productPrice" class="form-label">Product Price</label>
                <input type="number" class="form-control" id="productPrice" name="price"
                    placeholder="Enter product price" required>
            </div>

            <div class="mb-3">
                <label for="productDescription" class="form-label">Product Description</label>
                <textarea class="form-control" id="productDescription" name="description" rows="4"
                    placeholder="Enter product description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="productCompany" class="form-label">Product Company</label>
                <input type="text" class="form-control" id="productCompany" name="company"
                    placeholder="Enter product company" required>
            </div>

            <div class="mb-3">
                <label for="productType" class="form-label">Product Type</label>
                <input type="text" class="form-control" id="productType" name="type"
                    placeholder="Enter product type" required>
            </div>

            <div class="mb-3">
                <label for="productWarranty" class="form-label">Product Warranty</label>
                <input type="text" class="form-control" id="productWarranty" name="warranty"
                    placeholder="Enter product warranty (e.g., 1 year, 6 months)" required>
            </div>


            <div class="mb-3">
                <label for="productImage" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="productImage" name="image" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
