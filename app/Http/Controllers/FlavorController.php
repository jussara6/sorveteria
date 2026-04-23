<?php

namespace App\Http\Controllers;

use App\Models\Flavor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FlavorController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Flavor::query()->orderBy('name')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $flavor = Flavor::create($request->only(['name', 'description', 'is_available']));

        return response()->json($flavor, 201);
    }

    public function show(Flavor $flavor): JsonResponse
    {
        return response()->json($flavor);
    }

    public function update(Request $request, Flavor $flavor): JsonResponse
    {
        $flavor->update($request->only(['name', 'description', 'is_available']));

        return response()->json($flavor->fresh());
    }

    public function destroy(Flavor $flavor): JsonResponse
    {
        $flavor->delete();

        return response()->json(status: 204);
    }
}
