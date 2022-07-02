<?php

namespace App\PageSearch;

use Illuminate\Http\JsonResponse;
use App\Page;

class SearchController
{
    /**
     * Filter pages in admin panel.
     *
     * @param Request $request
     * @param Builder $builder
     * @return JsonResponse
     */
    public static function filter(Request $request, Builder $builder): JsonResponse
    {
        $pages = PageSearch::applyFiltersToQuery($request, $builder);
        $components = collect((new Page)->getAvailableComponents());

        return response()->json([
            'pages' => $pages,
            'components' => $components,
        ]);
    }

}