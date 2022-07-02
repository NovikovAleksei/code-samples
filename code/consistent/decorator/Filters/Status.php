<?php

namespace App\PageSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class Status implements Filter
{
    public static function apply(Builder $builder, $value)
    {
        if(!empty($value)) {
            return $builder->where('status', $value);
        }
        return $builder->orderByDesc('updated_at');
    }
}
