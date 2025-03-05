<?php

namespace App\Http\Controllers;
use App\Http\Requests\UpdateResourceFormRequest;
use App\Models\Resource;


class ResourceEditController extends Controller
{
    public function update(UpdateResourceFormRequest $request, Resource $resource)
    {
        //Obtenemos los datos validados
        $validated = $request->validated();
        unset($validated['github_id']);
        //Actualizamos los datos
        $resource->update($validated);

        //Devolvemos la respuesta
        return response()->json($resource, 200);
    }
}
