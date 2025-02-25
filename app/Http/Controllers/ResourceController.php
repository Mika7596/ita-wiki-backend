<?php

declare (strict_types= 1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateResourceFormRequest;
use App\Http\Requests\StoreResourceRequest;
use App\Models\Resource;

class ResourceController extends Controller
{
   public function store(CreateResourceFormRequest $request)
    {
        $validated = $request->validated();
        $resource = Resource::create($validated);
        return response()->json($resource, 201);
    }

    public function index()
    {
        $resources = Resource::all();
        return response()->json($resources, 200);
    }


}
