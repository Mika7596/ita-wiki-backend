<?php

namespace App\Http\Controllers;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\Resource;


class ResourceEditController extends Controller
{
    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        $validated = $request->validated();
        $resource->update($validated);
        return response()->json($resource, 200);
    }
}
