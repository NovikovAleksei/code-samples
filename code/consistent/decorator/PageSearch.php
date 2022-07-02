<?php

namespace App\PageSearch;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Page;

class PageSearch
{
    public static function applyFiltersToQuery(Request $request, Builder $query)
    {
        $query = Page::query();

        foreach ($request->all() as $filterName => $value) {
            $decorator = __NAMESPACE__ .'\\Filters\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $filterName)));

            if (class_exists($decorator)) {
                $query = $decorator::apply($query, $value);
            }
        }
        return $query->paginate(20);
    }
}
