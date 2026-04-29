<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFlavorRequest;
use App\Http\Requests\UpdateFlavorRequest;
use App\Http\Resources\FlavorResource;
use App\Models\Flavor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FlavorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return FlavorResource::collection(Flavor::query()->orderBy('name')->get());
    }

    public function store(StoreFlavorRequest $request): FlavorResource
    {
        $validated = $request->validated();

        $flavor = Flavor::create($validated);

        return new FlavorResource($flavor);
    }

    public function show(Flavor $flavor): FlavorResource
    {
        return new FlavorResource($flavor);
    }

    public function update(UpdateFlavorRequest $request, Flavor $flavor): FlavorResource
    {
        $validated = $request->validated();

        $flavor->update($validated);

        return new FlavorResource($flavor->fresh());
    }

    public function destroy(Flavor $flavor): JsonResponse
    {
        $flavor->delete();

        return response()->json(null, 204);
    }
}