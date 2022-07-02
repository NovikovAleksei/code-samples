<?php

namespace App\PageSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class QuerySearch implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        if(!empty($value)) {
            return $builder->where('title', 'like', '%' . $value . '%')
                ->orWhere('slug', 'like', '%' . $value . '%');
        }
        return $builder->orderByDesc('updated_at');
    }
}
