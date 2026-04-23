<?php

namespace App\Http\Controllers;

use App\Models\Flavor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FlavorController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Flavor::query()->orderBy('name')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:flavors,name'],
            'description' => ['nullable', 'string'],
            'is_available' => ['sometimes', 'boolean'],
        ]);

        $flavor = Flavor::create($validated);

        return response()->json($flavor, 201);
    }

    public function show(Flavor $flavor): JsonResponse
    {
        return response()->json($flavor);
    }

    public function update(Request $request, Flavor $flavor): JsonResponse
    {
        $validated = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('flavors', 'name')->ignore($flavor->getKey()),
            ],
            'description' => ['sometimes', 'nullable', 'string'],
            'is_available' => ['sometimes', 'boolean'],
        ]);

        $flavor->update($validated);

        return response()->json($flavor->fresh());
    }

    public function destroy(Flavor $flavor): JsonResponse
    {
        $flavor->delete();

        return response()->json(status: 204);
    }
}