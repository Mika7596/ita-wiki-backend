<?php

declare (strict_types= 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

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

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags, 200);
    }
}
