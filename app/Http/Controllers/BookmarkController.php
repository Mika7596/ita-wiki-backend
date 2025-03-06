<?php

declare (strict_types= 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    public function bookmarkSwitcherAndRetriever(Request $request)
    {
        $request->headers->set('Accept', 'application/json');
        $validated = $request->validated();
        if($request->$_POST){
            $githubId = $request->input('github_id', $request->query('github_id'));
            $resourceId = $request->input('resource_id', $request->query('resource_id'));
            $bookmark = Bookmark::where('github_id', $githubId)->where('resource_id', $resourceId)->first();
            if ($bookmark) {
                $bookmark->delete();
            } else {
                $bookmark = Bookmark::create($validated);
            }            
        }
        $bookmarks = Bookmark::all();
        return response()->json($bookmarks, 200);
    }
    // validation : $github_id required/integer/exists in roles && reource_id required/integer/exists in resources
}

/*
endpoints bookmarks :

GET '/bookmarks'
recibe github_id
devuelve json con github_id y array de resource_id (todos los bookmarks del usuario)

POST '/bookmarks' (conmutador)
recibe github_id y resource_id
- si no está en la tabla 'bookmarks' lo crea (clave UNIQUE compuesta por ambas foreign keys)
- si está en la tabla lo elimina
devuelve json con github_id y array de resource_id (todos los bookmarks del usuario)
(entiendo que el front "refrescará" el listado completo de bookmarks del usuario
*/
