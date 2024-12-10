@extends('layouts.app')

@section('title', 'Product Management')

@section('content')
    <h1>Product Management</h1>

    <!-- Go Back Button -->
    <a href="{{ route('index') }}" class="btn btn-secondary mb-3">Go Back to Home</a>

    <!-- Form for Adding Products -->
    <form method="POST" id="productForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="product_code" class="form-label">Product Code</label>
            <input type="text" class="form-control" name="product_code" id="product_code" required>
        </div>

        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="product_name" id="product_name" required>
        </div>

        <div class="mb-3">
            <label for="brand_id" class="form-label">Brand</label>
            <select class="form-select" name="brand_id" id="brand_id" required>
                <option value="">Select Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="selling_price" class="form-label">Selling Price</label>
            <input type="number" step="0.01" class="form-control" name="selling_price" id="selling_price" required>
        </div>

        <div class="mb-3">
            <label for="offer_price" class="form-label">Offer Price</label>
            <input type="number" step="0.01" class="form-control" name="offer_price" id="offer_price">
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Images</label>
            <input type="file" class="form-control" name="images[]" id="images" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>

    <!-- Table for Listing Products -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Selling Price</th>
                <th>Offer Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="productTable">
            @foreach($products as $product)
                <tr data-id="{{ $product->id }}">
                    <td>{{ $product->product_code }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->brand->brand_name }}</td>
                    <td>{{ $product->selling_price }}</td>
                    <td>{{ $product->offer_price }}</td>
                    <td>
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->first_image) }}" width="50" alt="Product Image">
                        @else
                            No Image
                        @endif
                    </td>

                    <td>
                        <button class="btn btn-danger delete-btn">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // Add Product
        $('#productForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('products.store') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token here
                },
                success: function(response) {
                    alert(response.success);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        // Delete Product
        $('.delete-btn').click(function() {
            if (confirm('Are you sure you want to delete this product?')) {
                const row = $(this).closest('tr');
                const productId = row.data('id');

                $.ajax({
                    url: `/products/${productId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        alert(response.success);
                        row.remove();
                    }
                    
                });
            }
        });

        // Fetch and display products
        function fetchProducts() {
            $.ajax({
                url: "{{ route('products.index') }}", // Route for fetching products
                type: 'GET',
                success: function(products) {
                    let rows = '';
                    products.forEach(product => {
                        const imagePath = product.images.length > 0 ? 
                            `<img src="/storage/${product.images[0].image_path}" alt="Product Image" width="50" height="50">` 
                            : 'No Image';
                        
                        rows += `
                            <tr>
                                <td>${product.product_code}</td>
                                <td>${product.product_name}</td>
                                <td>${imagePath}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#productTableBody').html(rows);
                },
                error: function(xhr) {
                    alert('Error fetching products: ' + xhr.responseJSON.message);
                }
            });
        }

        // Call the function to load products on page load
        $(document).ready(function() {
            fetchProducts();
        });
        </script>
@endsection
