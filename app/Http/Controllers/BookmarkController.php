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
     *     path="/api/bookmarks",
     *     summary="Create a bookmark",
     *     tags={"Bookmarks"},
     *     description="Creates a new bookmark and returns a confirmation message",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"github_id","resource_id"},
     *             @OA\Property(property="github_id", type="integer", example=6729608),
     *             @OA\Property(property="resource_id", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="github_id", type="integer", example=6729608),
     *             @OA\Property(property="resource_id", type="integer", example=11),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Conflict",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Bookmark already exists.")
     *         )
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
     *     path="/api/bookmarks",
     *     summary="Delete a bookmark",
     *     tags={"Bookmarks"},
     *     description="Deletes a bookmark and returns a confirmation message",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"github_id","resource_id"},
     *             @OA\Property(property="github_id", type="integer", example=6729608),
     *             @OA\Property(property="resource_id", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bookmark deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Bookmark not found")
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
     *     path="/api/bookmarks/{github_id}",
     *     summary="Get all bookmarks for a student",
     *     tags={"Bookmarks"},
     *     description="If the student's github_id exists it returns all bookmarks for that student or an empty array in case there is not any",
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
     *             type="object",
     *             @OA\Property(property="bookmarks", type="array", @OA\Items(ref="#/components/schemas/Bookmark"))
     *         )
     *     )
     * )
    */

    public function getStudentBookmarks(BookmarkRequest $request)
    {
        $bookmarks = Bookmark::where('github_id', $request->validated('github_id'))->get();
        return response()->json($bookmarks, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/bookmarks/toggle",
     *     summary="Toggle a bookmark",
     *     tags={"Bookmarks"},
     *     description="Creates or deletes a bookmark based on current state",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"github_id","resource_id"},
     *             @OA\Property(property="github_id", type="integer", example=6729608),
     *             @OA\Property(property="resource_id", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bookmark created successfully"),
     *             @OA\Property(property="bookmarked", type="boolean", example=true)
     *                  examples={
     *                      "created": {
     *                          "value": {
     *                              "message": "Bookmark created successfully", 
     *                               "bookmarked": true
     *                          }
     *                      },
     *                      "deleted": {
     *                          "value": {
     *                              "message": "Bookmark removed successfully",
     *                              "bookmarked": false
     *                          }
     *                      }
     *                  }
     *         )
     *     )
     * )
    */

    public function toggleBookmark(BookmarkRequest $request)
    {
        $validated = $request->validated();
        $bookmark = Bookmark::where('github_id', $validated['github_id'])
            ->where('resource_id', $validated['resource_id'])
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json([
                'message' => 'Bookmark removed successfully',
                'bookmarked' => false
            ], 200);
        } else {
            Bookmark::create($validated);
            return response()->json([
                'message' => 'Bookmark created successfully',
                'bookmarked' => true
            ], 200);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/bookmarks/toggle-refresh",
     *     summary="Toggle a bookmark and return updated list of bookmarks",
     *     tags={"Bookmarks"},
     *     description="Creates or deletes a bookmark based on its current state and returns the updated list of resources bookmarked by the user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"github_id","resource_id"},
     *             @OA\Property(property="github_id", type="integer", example=6729608),
     *             @OA\Property(property="resource_id", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Bookmark created successfully"),
     *             @OA\Property(property="bookmarked", type="boolean", example=true),
     *             @OA\Property(
     *                 property="bookmarks",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Bookmark")
     *             )
     *         ),
     *         examples={
     *             "created": {
     *                 "summary": "Bookmark created",
     *                 "value": {
     *                     "message": "Bookmark created successfully",
     *                     "bookmarked": true,
     *                     "bookmarks": [
     *                         {
     *                             "id": 1,
     *                             "github_id": 6729608,
     *                             "resource_id": 10,
     *                             "created_at": "2023-03-22T10:00:00Z",
     *                             "updated_at": "2023-03-22T10:00:00Z"
     *                         },
     *                         {
     *                             "id": 2,
     *                             "github_id": 6729608,
     *                             "resource_id": 11,
     *                             "created_at": "2023-03-22T11:00:00Z",
     *                             "updated_at": "2023-03-22T11:00:00Z"
     *                         }
     *                     ]
     *                 }
     *             },
     *             "deleted": {
     *                 "summary": "Bookmark deleted",
     *                 "value": {
     *                     "message": "Bookmark removed successfully",
     *                     "bookmarked": false,
     *                     "bookmarks": [
     *                         {
     *                             "id": 1,
     *                             "github_id": 6729608,
     *                             "resource_id": 10,
     *                             "created_at": "2023-03-22T10:00:00Z",
     *                             "updated_at": "2023-03-22T10:00:00Z"
     *                         }
     *                     ]
     *                 }
     *             }
     *         }
     *     )
     */

    public function toggleBookmarkAndRefresh(BookmarkRequest $request)
    {
        $validated = $request->validated();
        $bookmark = Bookmark::where('github_id', $validated['github_id'])
            ->where('resource_id', $validated['resource_id'])
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $message = 'Bookmark removed successfully';
            $bookmarked = false;
        } else {
            Bookmark::create($validated);
            $message = 'Bookmark created successfully';
            $bookmarked = true;
        }
    
        // Fetch the updated list of bookmarks for the user
        $updatedBookmarks = Bookmark::where('github_id', $validated['github_id'])->get();
    
        return response()->json([
            'message' => $message,
            'bookmarked' => $bookmarked,
            'bookmarks' => $updatedBookmarks
        ], 200);
    }
}