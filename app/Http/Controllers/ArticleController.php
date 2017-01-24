<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class ArticleController extends Controller
{
    /**
     * Render a specific view of Article set
     *
     * @param string $countryId
     * @param string $articleCategory
     * @return Response
     */
    public function show($countryId, $articleCategory)
    {
        $categoryName = 'front';

        $articlePage = strpos('_', $articleCategory) !== false
            ? ($categoryName = explode('_', $articleCategory)[1]) : 1;

        return response(view($categoryName == 'front' ? 'articlesFront' : 'articlesCategory', [
            'country' => $countryId,
            'category' => $categoryName == 'front' ? 'all' : $categoryName,
            'page' => $articlePage
        ]), 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }
}