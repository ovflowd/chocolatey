<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class ArticleController.
 */
class ArticleController extends BaseController
{
    /**
     * Render a specific view of Article set.
     *
     * @param string $countryId
     * @param string $articleCategory
     *
     * @return Response
     */
    public function many(string $countryId, string $articleCategory): Response
    {
        $category = ArticleCategory::find(strstr(($articleCategory =
            str_replace('.html', '', $articleCategory)), '_', true));

        $categoryPage = strstr(strrev($articleCategory), '_', true);

        return $articleCategory == 'front' ? $this->front() : $this->category($countryId, $category, $categoryPage,
            $categoryPage == 1 ? 0 : (10 * ($categoryPage - 1)));
    }

    /**
     * Render the Front Page of the Articles Page.
     *
     * @return Response
     */
    protected function front(): Response
    {
        return response(view('habbo-web-news.articles-front', ['set' => Article::orderBy('id', 'DESC')->limit(10)->get()]));
    }

    /**
     * Render a specific Category Articles Page.
     *
     * @TODO: Proper Way to use Country ID
     *
     * @param string          $countryId
     * @param ArticleCategory $category
     * @param int             $categoryPage
     * @param int             $start
     *
     * @return Response
     */
    protected function category(string $countryId, ArticleCategory $category, int $categoryPage, int $start): Response
    {
        $articles = Article::where('id', '>=', $start)->limit(10)->orderBy('id', 'DESC')->get()->filter(function ($item) use ($category) {
            return $category->name == 'all' || in_array($category, $item->categories);
        });

        return response(view('habbo-web-news.articles-category', [
            'category' => $category, 'page' => $categoryPage, 'categories' => ArticleCategory::all(), 'articles' => $articles,
        ]));
    }

    /**
     * Render a specific view of a specific Article.
     *
     * @TODO: Proper Way to use Country ID
     *
     * @param string $countryId
     * @param string $articleName
     *
     * @return Response
     */
    public function one(string $countryId, string $articleName): Response
    {
        if (($article = Article::find(strstr($articleName, '_', true))) == null) {
            return response()->json(null, 404);
        }

        $related = ($latest = Article::all())->filter(function ($item) use ($article) {
            return in_array($article->categories[0], $item->categories);
        });

        return response(view('habbo-web-news.articles-view',
            ['article' => $article, 'latest' => $latest->slice(0, 5), 'related' => $related->slice(0, 5)]
        ));
    }

    /**
     * Get All Habbo Articles as XML/RSS.
     *
     * @return Response
     */
    public function getRss()
    {
        return response(view('habbo-web-pages.habbo-rss', ['articles' => Article::limit(20)->get()]))->header('Content-Type', 'text/xml');
    }
}
