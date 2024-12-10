@extends('layouts.app')

@section('title', 'Welcome to Product Database')

@section('content')
    <div class="text-center mt-5">
        <h1>Welcome to Product Database</h1>
        <p>Manage your products and brands efficiently!</p>
        <div class="mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary mx-2">View Products</a>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary mx-2">View Brands</a>
        </div>
    </div>
@endsection
