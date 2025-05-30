<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Post; 
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Post::all();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products available!'], 200);
        }

        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|string', 
        ]);

        $product = Post::create($validated);

        return new ProductResource($product);
    }

    public function show($id)
    {
        $product = Post::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return new ProductResource($product);
    }

    public function update(Request $request, $id)
    {
        $product = Post::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validated = $request->validate([
            'name'  => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'image' => 'nullable|string',
        ]);

        $product->update($validated);

        return new ProductResource($product);
    }

    public function destroy($id)
    {
        $product = Post::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
