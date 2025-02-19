<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Models\Resource;

class ResourceController extends Controller
{
/*     public function store(StoreResourceRequest $request)
    {
        $validated = $request->validated();
        $resource = Resource::create($validated);
        return response()->json($resource, 201);
    } */

    public function get()
    {
        $resources = Resource::all();
        return response()->json($resources, 200);
    }

/*     public function destroy(Resource $resource)
    {
        $resource->delete();
        return response()->json(null, 204);
    } */
}
