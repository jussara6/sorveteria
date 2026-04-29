<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $products = Product::query()
            ->with(['category', 'flavors'])
            ->orderBy('name')
            ->get();

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request): ProductResource
    {
        $validated = $request->validated();

        $flavorIds = $validated['flavor_ids'] ?? null;
        unset($validated['flavor_ids']);

        $product = Product::create($validated);

        if ($flavorIds !== null) {
            $product->flavors()->sync($flavorIds);
        }

        return new ProductResource($product->load(['category', 'flavors']));
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load(['category', 'flavors']));
    }

    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        $validated = $request->validated();

        $flavorIds = $validated['flavor_ids'] ?? null;
        unset($validated['flavor_ids']);

        $product->update($validated);

        if ($flavorIds !== null) {
            $product->flavors()->sync($flavorIds);
        }

        return new ProductResource($product->load(['category', 'flavors']));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
