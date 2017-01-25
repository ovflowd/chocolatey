<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends BaseController
{
    /**
     * Render a specific view of Article set
     *
     * @param string $countryId
     * @param string $articleCategory
     * @return Response
     */
    public function many($countryId, $articleCategory)
    {
        $categoryName = strstr($articleCategory, '_') !== false
            ? str_replace('_', '-', substr($articleCategory, 0, strrpos($articleCategory, '_'))) : 'front';

        $categoryArray = explode('_', $articleCategory);

        $categoryPage = str_replace('.html', '', end($categoryArray));

        return response($categoryName == 'front' ? $this->front() :
            $this->category($countryId, $categoryName, $categoryPage), 200)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * Render the Front Page of the Articles Page
     *
     * @return View
     */
    protected function front()
    {
        return view('habbo-web-news.articles-front',
            ['set' => DB::select("SELECT * FROM azure_articles WHERE categories LIKE '%all%'  ORDER BY id ASC LIMIT 10")]);
    }

    /**
     * Render a specific Category Articles Page
     *
     * @TODO: Proper Way to use Country ID
     *
     * @param string $countryId
     * @param string $categoryName
     * @param string $categoryPage
     * @return View
     */
    protected function category($countryId, $categoryName, $categoryPage)
    {
        return view('habbo-web-news.articles-category', [
            'category' => $categoryName,
            'categories' => DB::select('SELECT * FROM azure_articles_categories'),
            'articleSet' => DB::select('SELECT * FROM azure_articles ' .
                'WHERE categories LIKE :category AND id >= :page ORDER BY id ASC LIMIT 10',
                [':category' => "%$categoryName%", ':page' => $categoryPage == 1
                    ? $categoryPage : ($categoryPage * 3)])
        ]);
    }

    /**
     * Render a specific view of a specific Article
     *
     * @TODO: Proper Way to use Country ID
     *
     * @param string $countryId
     * @param string $articleName
     * @return Response
     */
    public function one($countryId, $articleName)
    {
        $articleId = substr($articleName, 0, strpos($articleName, '_'));

        $articleContent = DB::select('SELECT * FROM azure_articles WHERE id = :id', [':id' => $articleId])[0];

        $articleCategory = explode(',', $articleContent->categories);

        return response(view('habbo-web-news.articles-view', [
            'article' => $articleContent,
            'latest' => DB::select('SELECT id, createdAt, title FROM azure_articles ORDER BY id ASC LIMIT 5'),
            'related' => DB::select('SELECT id, createdAt, title FROM azure_articles WHERE categories LIKE :category LIMIT 5',
                [':category' => '%' . end($articleCategory) . '%'])
        ]), 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
