<?php

use App\Models\Category;
use App\Models\Url;
use Illuminate\Support\Facades\Auth;

if (! function_exists('get_title_url')) {
    function get_title_url($url)
    {
        $content = file_get_contents($url);

        if (preg_match('/<title[^>]*>(.*?)<\/title>/', $content, $matches)) {
            return trim($matches[1]); // Return the title text
        }
        return null; // Return null if no title is found
    }
}

if (! function_exists('models_count')) {
    function models_count($model = null)
    {
        $data = [];
        $data['categories'] = Category::count();
        if($model)
        {
            $data['reviews'] = $model->reviews()->count();
            $data['urls'] = Url::where('category_id', $model->id)->count();
        }

        return $data;
    }
}

if (! function_exists('calculate_average')) {
    function calculate_average($item_sum, $item_count)
    {
        $average = floor($item_sum / (!empty($item_count) ? $item_count : 1));

        return $average;
    }
}

if (! function_exists('calculate_review')) {
    function calculate_review($item_sum, $item_count)
    {
        $average = (int) min($item_sum / (!empty($item_count) ? $item_count : 1), 5);

        return $average;
    }
}

if (! function_exists('category_exist')) {
    function category_exist($category)
    {

        $favourites = Auth::user()->favourites()
        ->where('favouritable.category.id', '!=', $category->id)
        ->get();

        dd($favourites );

    }
}



