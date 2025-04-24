<?php

declare (strict_types= 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Resource;

class TagController extends Controller
{
    /**
     * @OA\Get(
     *     path="/tags",
     *     summary="Get all tags",
     *     tags={"Tags"},
     *     description="Tags used in resources",
     *     @OA\Response(
     *         response=200,
     *         description="A list of tags",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Tag")
     *         )
     *     )
     * )
    */

    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags, 200);
    }

    /**
     * @OA\Get(
     *     path="/tags/frequency",
     *     summary="Get tag frequencies",
     *     tags={"Tags"},
     *     description="Frequencies of tags used in resources",
     *     @OA\Response(
     *         response=200,
     *         description="An object with tag names as keys and frequencies as values",
     *         @OA\JsonContent(
     *             type="object",
     *             additionalProperties=@OA\Schema(type="integer"),
     *             example={"mongodb": 3, "rest": 5, "oop": 2}
     *         )
     *     )
     * )
    */

    public function getTagsFrequency()
    {
        $frequencies = Resource::all()
            ->pluck('tags')
            ->filter()
            ->flatten()
            ->countBy()
            ->all();

        return response()->json($frequencies, 200);
    }
}