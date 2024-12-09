<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = \App\Models\Brand::all();
        return view('brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|unique:brands,brand_name|max:255',
        ]);

        \App\Models\Brand::create(['brand_name' => $request->brand_name]);

        return response()->json(['success' => 'Brand added successfully!']);
    }

    public function destroy($id)
    {
        $brand = \App\Models\Brand::findOrFail($id);
        $brand->delete();

        return response()->json(['success' => 'Brand deleted successfully!']);
    }
}
