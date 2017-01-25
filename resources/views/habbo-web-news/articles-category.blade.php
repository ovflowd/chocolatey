<!-- View stored in resources/views/ArticlesCategory.php -->
<section>
    <header class="news-category__header">
        <span translate="NEWS_SHOW_MORE"></span>
        <nav class="news-category__navigation">
            <ul class="news-category__list">
                @foreach ($categories as $articleCategory)
                    <li class="news-category__item">
                        <a href="/community/category/{{$articleCategory->link}}"
                           translate="{{$articleCategory->translate}}"
                           class="@if ($articleCategory->link == $category) news-category__link--active news-category__link @else news-category__link @endif">
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </header>
    @foreach ($articleSet as $articleContent)
        <article class="news-header">
            <a href="/community/article/{{$articleContent->id}}/content"
               class="news-header__link news-header__banner">
                <figure class="news-header__viewport">
                    <img src="{{$articleContent->thumbnailUrl}}"
                         alt="{{$articleContent->title}}" class="news-header__image news-header__image--thumbnail">
                </figure>
            </a>
            <a href="/community/article/{{$articleContent->id}}/content" class="news-header__link news-header__wrapper">
                <h2 class="news-header__title">{{$articleContent->title}}</h2>
            </a>
            <aside class="news-header__wrapper news-header__info">
                <time class="news-header__date">
                    @{{ <?= strtotime($articleContent->createdAt) ?> | date: 'mediumDate' }}
                </time>
                <ul class="news-header__categories">
                    @foreach (explode(',', $articleContent->categories) as $articleCategory)
                        <?php $articleCategoryContent = DB::select('SELECT * FROM azure_articles_categories WHERE link = :link',
                            [':link' => $articleCategory])[0]; ?>
                        <li class="news-header__category">
                            <a href="/community/category/{{$articleCategoryContent->link}}/content"
                               class="news-header__category__link"
                               translate="{{$articleCategoryContent->translate}}"></a>
                        </li>
                    @endforeach
                </ul>
            </aside>
            <p class="news-header__wrapper news-header__summary">{{$articleContent->description}}</p>
        </article>
    @endforeach
</section>