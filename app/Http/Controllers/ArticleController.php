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
    public function many($countryId, $articleCategory): Response
    {
        $categoryName = str_replace('.html', '', strstr($articleCategory, '_', true));

        return $articleCategory == 'front.html' ? $this->front() : $this->category($countryId, $categoryName);
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
     * @return Response
     */
    protected function category($countryId, $categoryName): Response
    {
        return response(view('habbo-web-news.articles-category', [
            'category' => $categoryName,
            'categories' => ArticleCategory::all(),
            'articleSet' => $categoryName != 'all' ?
                Article::where('categories', 'like', "%$categoryName%")->get()
                : Article::all()
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
    public function one($countryId, $articleName): Response
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
