<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Products::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|unique|max:128',
            'price'      => 'required|numeric|between:0,999.99|decimal:0,2',
            'image_path' => 'nullable|string|max:255',
        ]);

        $product = Products::create($validated);
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'  => 'sometimes|required|string|max:128', 
            'price' => 'sometimes|required|numeric',
        ]);
        
        $product = Products::find($id); 

        if ($product) {
            $product->update($validated); 
            return response()->json($product, 200);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy($id)
    {
        $product = Products::find($id);
        
        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Deleted successfully'], 200);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }
}