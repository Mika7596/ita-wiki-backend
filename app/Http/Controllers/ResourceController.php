<?php

declare (strict_types= 1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Models\Resource;

    /**
     * @OA\Info(
     *  title="Swagger Documentation for ITA-Wiki",
     *  version="1.0.0.0",
     *  description="Project ITA-Wiki documentation wall"
     * )
     */

class ResourceController extends Controller
{
    public function store(StoreResourceRequest $request)
    {
        $validated = $request->validated();
        $resource = Resource::create($validated);
        return response()->json($resource, 201);
    }

    /**
     * @OA\Get(
     *  path="/api/resources",
     *  summary="Get all resources",
     *  tags={"Resources"},
     *  description="return a list of all resources",
     *  @OA\Response(
     *     response=200,
     *     description="Resource list",
     *     @OA\JsonContent(
     *      type="array",
     *      @OA\Items(ref="#/components/schemas/Resource")
     *      )
     *     )
     * )
     */

    public function index()
    {
        $resources = Resource::all();
        return response()->json($resources, 200);
    }

}
