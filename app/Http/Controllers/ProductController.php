<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of all products 
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Get all products 
        $products = Product::with('images')->get();

        return response()->json([
            'message' => 'Products retrieved successfully',
            'products' => $products
        ], 200);
    }

    /**
     * Display a single product 
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
    
        $product = Product::with(['images', 'comments.user'])->find($id);

        // Check if product exists
        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Product retrieved successfully',
            'product' => $product
        ], 200);
    }

    /**
     * Store a newly created product (Admin only)
     * 
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        // Create the product
        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock_count' => $request->stock_count,
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    /**
     * Update the specified product (Admin only)
     * 
     * @param UpdateProductRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        // Find the product
        $product = Product::find($id);

        // Check if product exists
        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        // Update only the fields that are present in the request
        $product->update($request->only([
            'title',
            'description',
            'price',
            'stock_count'
        ]));

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ], 200);
    }

    /**
     * Remove the specified product (Admin only)
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        // Find the product
        $product = Product::find($id);

        // Check if product exists
        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        // Delete the product 
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}