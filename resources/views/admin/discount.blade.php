<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Table with Discounts</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Product Table</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Discount (%)</th>
                    <th scope="col">Already Discount (%)</th>


                </tr>
            </thead>
            <tbody>
                <!-- Loop through products -->
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            <form action="{{ route('product.discount', $product->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <div class="input-group">
                                    <input type="number" name="discount" class="form-control"
                                        placeholder="Enter discount" value="{{ $product->discount ?? 0 }}">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </td>
                        <td>
                            <p class="text-center">{{ $product->Discount }} </p>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('admin-home') }}" class="btn btn-secondary">Back</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
