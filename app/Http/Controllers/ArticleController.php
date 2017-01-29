<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Response;
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
            ['set' => Article::where('categories', 'like', '%all%')->orderBy('id', 'ASC')->limit(10)->get()]);
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
            'categories' => ArticleCategory::all(),
            'articleSet' => Article::where('categories', 'like', "%$categoryName%")
                ->where('id', '>=', $categoryPage == 1 ? $categoryPage : ($categoryPage * 3))
                ->orderBy('id', 'ASC')->limit(10)->get()
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

        $articleContent = Article::find($articleId);

        if ($articleContent == null)
            return response('', 404);

        $articleCategory = $articleContent->categories;

        return response(view('habbo-web-news.articles-view', [
            'article' => $articleContent,
            'latest' => Article::select('id', 'createdAt', 'title')->orderBy('id', 'ASC')->limit(10)->get(),
            'related' => Article::where('categories', 'like', '%' . end($articleCategory)->link . '%')
                ->orderBy('id', 'ASC')->limit(5)->get()
        ]), 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
