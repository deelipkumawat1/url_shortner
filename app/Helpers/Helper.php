<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

if(!function_exists('applyDateFilter')) {
    function applyDateFilter(Builder $query, ?string $filter, ?string $fromDate = null, ?string $toDate = null, string $column = 'created_at'): Builder {
        $filter = $filter ?? 'month';

        switch ($filter) {
            case 'today':
                $query->whereDate($column, Carbon::today());
                break;

            case 'last_week':
                $query->whereBetween($column, [
                    Carbon::now()->subWeek()->startOfWeek(),
                    Carbon::now()->subWeek()->endOfWeek(),
                ]);
                break;
            case 'last_month':
                $query->whereBetween($column, [
                    Carbon::now()->subMonth()->startOfMonth(),
                    Carbon::now()->subMonth()->endOfMonth(),
                ]);
                break;
        }

        return $query;
    }
}
