<?php

declare (strict_types= 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookmarkRequest;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    public function studentBookmarkCreate(BookmarkRequest $request)
    {
        $validated = $request->validated();
        $bookmark = Bookmark::create($validated);
        return response()->json($bookmark, 201);
    }

    public function studentBookmarkDelete(BookmarkRequest $request)
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

    public function studentBookmarksGetter(BookmarkRequest $request, $github_id)
    {
        $bookmarks = Bookmark::where('github_id', $github_id)->get();
        return response()->json($bookmarks, 200);
    }
}