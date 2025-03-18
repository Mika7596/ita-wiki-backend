<?php

declare (strict_types= 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookmarkRequest;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    /**
     * @OA\Post(
     *     path="/bookmarks",
     *     summary="Create a bookmark",
     *     tags={"Bookmarks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"github_id","resource_id"},
     *             @OA\Property(property="github_id", type="integer", example=6729608),
     *             @OA\Property(property="resource_id", type="integer", example=11)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/Bookmark")
     *     )
     * )
    */

    public function createStudentBookmark(BookmarkRequest $request)
    {
        $validated = $request->validated();
        $existingBookmark = Bookmark::where('github_id', $validated['github_id'])
        ->where('resource_id', $validated['resource_id'])
        ->first();

        if ($existingBookmark) {
            return response()->json([
                'message' => 'Bookmark already exists.',
            ], 409); // HTTP 409 Conflict
        }

        $bookmark = Bookmark::create($validated);
        return response()->json($bookmark, 201);
    }

    /**
     * @OA\Delete(
     *     path="/bookmarks",
     *     summary="Delete a bookmark",
     *     tags={"Bookmarks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"github_id","resource_id"},
     *             @OA\Property(property="github_id", type="integer", example=6729608),
     *             @OA\Property(property="resource_id", type="integer", example=11)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bookmark deleted successfully")
     *         )
     *     )
     * )
    */

    public function deleteStudentBookmark(BookmarkRequest $request)
    {
        $validated = $request->validated();
        $bookmark = Bookmark::where('github_id', $validated['github_id'])
            ->where('resource_id', $validated['resource_id'])
            ->first();
        if($bookmark) {
            $bookmark->delete();
            return response()->json(['message' => 'Bookmark deleted successfully'], 200);
        }
        return response()->json(['error' => 'Bookmark not found'], 404);
    }

    /**
     * @OA\Get(
     *     path="/bookmarks/{github_id}",
     *     summary="Get all bookmarks for a student",
     *     tags={"Bookmarks"},
     *     @OA\Parameter(
     *         name="github_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=6729608)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Bookmark")
     *         )
     *     )
     * )
    */

    public function getStudentBookmarks(BookmarkRequest $request)
    {
        return response()->json(
            Bookmark::where('github_id', $request->validated('github_id'))->get(),
            200
        );
    }
}