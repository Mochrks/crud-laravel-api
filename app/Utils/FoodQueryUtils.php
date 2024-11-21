<?php

namespace App\Utils;

use App\Models\Foods;

class FoodQueryUtils
{
    public static function buildQuery($params)
    {
        $query = Foods::with('category');

        // params foodName
        if (isset($params['foodName'])) {
            $query->where('food_name', 'like', '%' . $params['foodName'] . '%');
        }
        // params categoryId
        if (isset($params['categoryId'])) {
            $query->where('category_id', $params['categoryId']);
        }
        // params sort
        if (isset($params['sortBy'])) {
            $parts = explode(',', $params['sortBy']);
            $sortBy = $parts[0];
            $sortDirection = isset($parts[1]) && strtolower($parts[1]) == 'desc' ? 'desc' : 'asc';

            switch ($sortBy) {
                case 'foodName':
                    $query->orderBy('food_name', $sortDirection);
                    break;
            }
        } else {
            $query->orderBy('food_name', 'asc');
        }

        return $query;
    }
}
