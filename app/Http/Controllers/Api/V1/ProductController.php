<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\AQC\V1\Product\{CreateProduct, GetProducts, UpdateProduct};
use App\Http\Requests\V1\Product\CreateOrUpdateProductRequest;
use Illuminate\Http\{JsonResponse, Request};
use App\Models\Product;

final class ProductController 
{
    public function index(Request $request)
    {
        $products = (new GetProducts)->handle($request->all());

        return response()->json($products, 200);
    }

    public function store(CreateOrUpdateProductRequest $request): JsonResponse
    {
        $product = (new CreateProduct)->handle($request->validated());

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product, 200);
    }

    public function update(CreateOrUpdateProductRequest $request, Product $product)
    {
        $product = (new UpdateProduct)->handle($product, $request->validated());

        return response()->json($product, 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
