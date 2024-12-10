@extends('layouts.app')

@section('title', 'Brand Management')

@section('content')
    <h1>Brand Management</h1>

    <!-- Go Back Button -->
    <a href="{{ route('index') }}" class="btn btn-secondary mb-3">Go Back to Home</a>

    <form id="brandForm">
        <div class="mb-3">
            <label for="brand_name" class="form-label">Brand Name</label>
            <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Enter Brand Name">
        </div>
        <button type="submit" class="btn btn-primary">Add Brand</button>
    </form>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Brand Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="brandTable">
            @foreach($brands as $brand)
                <tr data-id="{{ $brand->id }}">
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->brand_name }}</td>
                    <td>
                        <button class="btn btn-danger delete-btn">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // Add Brand
        $('#brandForm').submit(function(e) {
            e.preventDefault();
            const brandName = $('#brand_name').val();

            $.ajax({
                url: "{{ route('brands.store') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    brand_name: brandName,
                },
                success: function(response) {
                    alert(response.success);
                    location.reload();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.errors.brand_name[0]);
                }
            });
        });

        // Delete Brand
        $('.delete-btn').click(function() {
            if (confirm('Are you sure you want to delete this brand?')) {
                const row = $(this).closest('tr');
                const brandId = row.data('id');

                $.ajax({
                    url: `/brands/${brandId}`,
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
    </script>
@endsection
