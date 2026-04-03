<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\Product\CreateProductRequest;
use App\AQC\V1\Product\{CreateProduct, GetProducts};
use Illuminate\Http\{JsonResponse, Request};

final class ProductController 
{
    public function index(Request $request)
    {
        $products = (new GetProducts)->handle($request->all());

        return response()->json($products, 200);
    }

    public function store(CreateProductRequest $request): JsonResponse
    {
        $product = (new CreateProduct)->handle($request->validated());

        return response()->json($product, 201);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
