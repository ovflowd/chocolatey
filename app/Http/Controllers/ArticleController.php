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
        $articleContent = '<section></section>';

        return (new Response($articleContent, 200))->header('Content-Type', 'text/html; charset=UTF-8');
    }
}