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

namespace Azure\Controllers;

use Azure\Database\Adapter;
use Azure\Types\Controller as ControllerType;
use Azure\View\Misc;

/**
 * Class Aid
 * @package Azure\Controllers
 */
class ComposeNews extends ControllerType
{
    /**
     * function construct
     * create a controller for articles
     * @param int $data
     */

    function __construct($data = 0)
    {

    }

    /**
     * function show
     * render and return content
     * @param int $data
     * @return null|string
     */
    function show($data = 0)
    {
        $v = explode('_', Misc::escape_text($data));

        unset($v[0]);

        $data = str_replace('_', '-', implode('_', $v));

        $v = null;

        Adapter::query("SET NAMES utf8");
        $fetch = Adapter::fetch_array(Adapter::secure_query("SELECT * FROM cms_articles WHERE internal_link = :internalink LIMIT 1", [':internalink' => $data]));

        if ($fetch != null):
            $article = '<article>
    <header class="news-header news-header--single">
        <div class="news-header__banner">
            <figure class="news-header__viewport">
                <img src="' . $fetch['image'] . '"
                     alt="' . $fetch['title'] . '"
                     class="news-header__image news-header__image--featured">
            </figure>
        </div>
        <social-share class="social-share--news"></social-share>
        <h1 class="news-header__wrapper news-header__title">' . $fetch['title'] . '</h1>
        <aside class="news-header__wrapper news-header__info">
            <time class="news-header__date">{{ ' . $fetch['createdate'] . ' | date: \'mediumDate\' }}</time>
        </aside>
        <p class="news-header__wrapper news-header__summary">' . $fetch['description'] . '</p>
    </header>
    <div class="news-article">
        ' . str_replace(['\r', '\n', '\\'], '', $fetch['text']) . '
    </div>

    <div class="news-footer">
    </div>

</article>
';
        else:
            $article = '';
        endif;

        return $article;
    }
}