<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::query()
            ->with(['category', 'flavors'])
            ->orderBy('name')
            ->get();

        return response()->json($products);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_available' => ['sometimes', 'boolean'],
            'flavor_ids' => ['sometimes', 'array'],
            'flavor_ids.*' => ['integer', 'exists:flavors,id'],
        ]);

        $flavorIds = $validated['flavor_ids'] ?? null;
        unset($validated['flavor_ids']);

        $product = Product::create($validated);

        if ($flavorIds !== null) {
            $product->flavors()->sync($flavorIds);
        }

        return response()->json($product->load(['category', 'flavors']), 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product->load(['category', 'flavors']));
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($product->getKey()),
            ],
            'description' => ['sometimes', 'nullable', 'string'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'is_available' => ['sometimes', 'boolean'],
            'flavor_ids' => ['sometimes', 'array'],
            'flavor_ids.*' => ['integer', 'exists:flavors,id'],
        ]);

        $flavorIds = $validated['flavor_ids'] ?? null;
        unset($validated['flavor_ids']);

        $product->update($validated);

        if ($flavorIds !== null) {
            $product->flavors()->sync($flavorIds);
        }

        return response()->json($product->load(['category', 'flavors']));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
