<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TagNode;
use App\Models\ResourceNode;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class TagNodeController extends Controller
{
    
    public function index()
    {
        $tags = TagNode::all();
        return response()->json($tags, 200);
    }

    
    public function getTagsFrequency()
    {
        $frequencies = ResourceNode::all()
            ->pluck('tags')
            ->filter()
            ->flatten()
            ->countBy()
            ->all();

        return response()->json($frequencies, 200);
    }

   
    public function getCategoryTagsFrequency()
    {
        $categorizedResources = ResourceNode::all()->groupBy('category');
        $frequencies = [];

        foreach ($categorizedResources as $category => $resources) {
            $categoryFrequencies = $resources
                ->pluck('tags')
                ->filter()
                ->flatten()
                ->countBy()
                ->all();
            $frequencies[$category] = $categoryFrequencies;
        }

        return response()->json($frequencies, 200);
    }

    
    public function getCategoryTagsId(): JsonResponse
    {
        $resourcesByCategory = ResourceNode::all()->groupBy('category');
        $tagsByCategory = [];

        foreach ($resourcesByCategory as $category => $resources) {
            $tagNames = $resources
                ->pluck('tags')
                ->filter()
                ->flatten()
                ->unique()
                ->values();

            $tagIds = TagNode::whereIn('name', $tagNames)->pluck('id')->all();
            $tagsByCategory[$category] = $tagIds;
        }

        return response()->json($tagsByCategory, 200);
    }
}
