<?php

/*
 * * azure project presents:
                                          _
                                         | |
 __,   __          ,_    _             _ | |
/  |  / / _|   |  /  |  |/    |  |  |_|/ |/ \_
\_/|_/ /_/  \_/|_/   |_/|__/   \/ \/  |__/\_/
        /|
        \|
				azure web
				version: 1.0a
				azure team
 * * be carefully.
 */

namespace Azure\Controllers\ADefault\APublic;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;

/**
 * Class Promos
 * @package Azure\Controllers\ADefault\APublic
 */
class Promos extends ControllerType
{
    /**
     * function construct
     * create a controller for promos
     */

    function __construct()
    {

    }

    /**
     * function show
     * render and return content
     */
    function show()
    {
        //header('Content-type: application/json');
        //return Data::compose_news(true);
		
		$selectedCategory = substr_replace(strstr(str_replace('_', '-', end(explode('/', $_SERVER['REQUEST_URI']))), '1', true), '', -1);
		
		if(!empty($selectedCategory)):
		
			$catquery = Adapter::secure_query("SELECT id FROM cms_articles_categories WHERE link = :link LIMIT 1", [':link' => $selectedCategory]);
		
			$catId = Adapter::row_count($catquery) == 0 ? 1 : Adapter::fetch_object($catquery)->id;
			
			$catlegal = '';
			
			foreach(Adapter::query("SELECT * FROM cms_articles_categories ORDER BY id ASC") as $catrow):
				
				$tt = $selectedCategory == $catrow['link'] ? 'news-category__link news-category__link--active' : 
					'news-category__link';
			
				$catlegal .= '
					<li class="news-category__item">
						<a href="/community/category/' . $catrow['link'] . '" translate="' . $catrow['translate'] . '"
						   class="' . $tt . '"></a>
					  </li>';
			endforeach;
			
			$string_history = '<section>
			<header class="news-category__header">
			<span translate="NEWS_SHOW_MORE"></span>
			<nav class="news-category__navigation">
				<ul class="news-category__list">
					  ' . $catlegal . '
				</ul>
			</nav>
			</header>
			';
		
		endif;

        Adapter::query("SET NAMES utf8");
        foreach (Adapter::query("SELECT * FROM cms_articles WHERE `type` = 'article' ORDER BY id DESC") as $row):

            $url = ($row['external_link'] != 'default') ? $row['external_link'] : "/community/article/{$row['id']}/{$row['internal_link']}";

			$categories = '';
			
			$catlist = explode(',', $row['categories']);
			
			if(!in_array($catId, $catlist) && !empty($selectedCategory))
				continue;
			
			foreach($catlist as $category):
				$fquery = Adapter::fetch_object(Adapter::query("SELECT * FROM cms_articles_categories WHERE id = '$category'"));
				

				$categories .= '
				<li class="news-header__category">
                    <a href="/community/category/' . $fquery->link . '" class="news-header__category__link" translate="' . $fquery->translate . '"></a>
                </li>';
			endforeach;
			
			$stype = empty($selectedCategory) ? 'news-header--column' : '';
			
            $string_history .= '<article class="news-header ' . $stype . '">
        <a href="' . $url . '" class="news-header__link news-header__banner">
            <figure class="news-header__viewport">
                <img src="' . $row['image'] . '"
                     alt="' . $row['title'] . '" class="news-header__image news-header__image--featured">
                <img src="' . $row['imagemini'] . '"
                     alt="' . $row['title'] . '" class="news-header__image news-header__image--thumbnail">
            </figure>
        </a>
        <a href="' . $url . '" class="news-header__link news-header__wrapper">
            <h2 class="news-header__title">' . $row['title'] . '</h2>
        </a>
        <aside class="news-header__wrapper news-header__info">
            <time class="news-header__date">{{ ' . $row['createdate'] . ' | date: \'mediumDate\' }}</time>
			<ul class="news-header__categories">
                ' . $categories . '
            </ul>
        </aside>
        <p class="news-header__wrapper news-header__summary">' . $row['description'] . '</p>
    </article>';

        endforeach;

        $string_history .= '</section>';

        return $string_history;
    }
}
