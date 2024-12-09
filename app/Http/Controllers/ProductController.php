<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;



class ProductController extends Controller
{
    /*public function index()
    {
        $products = Product::with(['images' => function ($query) {
            $query->limit(1); // Fetch only one image per product
        }])->get();

        //return response()->json($products);
        $brands = Brand::all(); // Fetch all brands to populate the dropdown

        // Pass the products to the view
        return view('products.index', compact('products', 'brands'));
    }*/

    public function index()
    {
        // $products = Product::with([/*'brand',*/ 'images' => function ($query) {
        //     $query->limit(1); // Fetch only one image per product
        // }])->get();

        $products = Product::with('images')->get();

        // Loop through each product to fetch the first image
        foreach ($products as $product) {
            $product->first_image = $product->images->isNotEmpty() ? $product->images->first()->image_path : null;
        }

        $brands = Brand::all(); // Fetch all brands to populate the dropdown

        return view('products.index', compact('products', 'brands'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|unique:products,product_code',
            'product_name' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'selling_price' => 'required|numeric',
            'offer_price' => 'nullable|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,avif|max:2048',
        ]);

        // Create the product
        $product = \App\Models\Product::create($request->only('product_code', 'product_name', 'brand_id', 'selling_price', 'offer_price'));

        // Handle image uploads
        if ($request->hasFile('images')) 
        {
            foreach ($request->file('images', []) as $image) 
            {
                $path = $image->store('product_images', 'public');
                $product->images()->create(['product_id' => $product->id,'image_path' => $path]);
            }
        }

        return response()->json(['success' => 'Product added successfully!']);
    }


    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);

        // Delete associated images
        foreach ($product->images as $image) {
            \Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return response()->json(['success' => 'Product deleted successfully!']);
    }
}
