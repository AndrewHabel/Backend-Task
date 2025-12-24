<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\UploadImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Upload multiple images for a product (Admin only)
     * 
     * @param UploadImageRequest $request
     * @return JsonResponse
     */
    public function upload(UploadImageRequest $request): JsonResponse
    {
        // Check if product exists
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        // Array to store uploaded image data
        $uploadedImages = [];

        // Loop through each uploaded image
        foreach ($request->file('images') as $image) {
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store the image in storage/app/public/products
            $path = $image->storeAs('products', $filename, 'public');

            // Save image path to database
            $productImage = ProductImage::create([
                'product_id' => $request->product_id,
                'image_path' => $path,
            ]);

            // Add to uploaded images array
            $uploadedImages[] = $productImage;
        }

        return response()->json([
            'message' => 'Images uploaded successfully',
            'images' => $uploadedImages,
            'count' => count($uploadedImages)
        ], 201);
    }
}