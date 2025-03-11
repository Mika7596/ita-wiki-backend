<?php

declare (strict_types= 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookmarkRequest;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    public function studentBookmarksSwitcher(BookmarkRequest $request)
    {
        $validated = $request->validated();
        $bookmark = Bookmark::where('github_id', $validated['github_id'])
            ->where('resource_id', $validated['resource_id'])
            ->first();
        if ($bookmark) {
            $bookmark->delete();
        } else {
            $bookmark = Bookmark::create($validated);
        }
        
        $bookmarks = Bookmark::where('github_id', $validated['github_id'])->get();
        return response()->json($bookmarks, 200);
    }

    public function studentBookmarksGetter(BookmarkRequest $request, $github_id)
    {
        $bookmarks = Bookmark::where('github_id', $github_id)->get();
        return response()->json($bookmarks, 200);
    }
}