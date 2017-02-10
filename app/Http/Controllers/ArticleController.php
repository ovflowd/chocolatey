<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Response;
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
    public function many(string $countryId, string $articleCategory): Response
    {
        $categoryName = strstr(($articleCategory = str_replace('.html', '', $articleCategory)), '_', true);

        $categoryPage = strstr(strrev($articleCategory), '_', true);

        return $articleCategory == 'front' ? $this->front() :
            $this->category($countryId, $categoryName, $categoryPage, $categoryPage == 1 ? 0 : (10 * ($categoryPage - 1)));
    }

    /**
     * Render the Front Page of the Articles Page
     *
     * @return Response
     */
    protected function front(): Response
    {
        return response(view('habbo-web-news.articles-front', ['set' =>
            Article::orderBy('id', 'ASC')->limit(10)->get()]));
    }

    /**
     * Render a specific Category Articles Page
     *
     * @TODO: Proper Way to use Country ID
     *
     * @param string $countryId
     * @param string $categoryName
     * @param int $categoryPage
     * @param int $start
     * @return Response
     */
    protected function category(string $countryId, string $categoryName, int $categoryPage, int $start): Response
    {
        $category = ArticleCategory::find($categoryName);

        $articles = Article::where('id', '>=', $start)->limit(10)->get()->filter(function ($item) use ($category) {
            return $category->link == 'all' || in_array($category, $item->categories);
        });

        return response(view('habbo-web-news.articles-category', [
            'category' => $categoryName,
            'nextPage' => ($categoryPage + 1),
            'categories' => ArticleCategory::all(),
            'articleSet' => $articles
        ]));
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
    public function one(string $countryId, string $articleName): Response
    {
        $articleContent = Article::find(substr($articleName, 0, strpos($articleName, '_')));

        if ($articleContent == null)
            return response()->json(null, 404);

        return response(view('habbo-web-news.articles-view', [
            'article' => $articleContent,
            'latest' => Article::select('id', 'createdAt', 'title')->orderBy('id', 'ASC')->limit(10)->get(),
            'related' => Article::where('categories', 'like', '%' . $articleContent->categories[0]->link . '%')
                ->orderBy('id', 'ASC')->limit(5)->get()
        ]));
    }
}
