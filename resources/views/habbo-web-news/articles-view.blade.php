<article>
    <header class="news-header news-header--single">
        <div class="news-header__banner">
            <figure class="news-header__viewport">
                <img src="{{$article->imageUrl}}"
                     alt="{{$article->title}}"
                     class="news-header__image news-header__image--featured">
            </figure>
        </div>
        <habbo-social-share type="news"></habbo-social-share>
        <h1 class="news-header__wrapper news-header__title">Race to the limit!</h1>
        <aside class="news-header__wrapper news-header__info">
            <time class="news-header__date">
                @{{ <?= strtotime($article->createdAt) ?> | date: 'mediumDate' }}
            </time>
            <ul class="news-header__categories">
                @foreach (explode(',', $article->categories) as $articleCategory)
                    <?php $articleCategoryContent = DB::select('SELECT * FROM azure_articles_categories WHERE link = :link',
                        [':link' => $articleCategory])[0]; ?>
                    <li class="news-header__category">
                        <a href="/community/category/{{$articleCategoryContent->link}}"
                           class="news-header__category__link"
                           translate="{{$articleCategoryContent->translate}}"></a>
                    </li>
                @endforeach
            </ul>
        </aside>
        <p class="news-header__wrapper news-header__summary">
            {{$article->description}}
        </p>
    </header>
    <div class="news-article">
        {{$article->content}}
    </div>

    <div class="news-footer">
        <aside class="news-box">
            <h4 translate="NEWS_RELATED"></h4>
            <ul>
                @foreach ($related as $relatedContent)
                    <li class="news-box__item">
                        <a href="/community/article/{{$relatedContent->id}}/content" class="news-box__link">
                            {{$relatedContent->title}}
                        </a>
                        <time class="news-box__date">
                            (@{{ <?= strtotime($relatedContent->createdAt) ?> | date: 'mediumDate' }})
                        </time>
                    </li>
                @endforeach
            </ul>
        </aside>
        <aside class="news-box">
            <h4 translate="NEWS_NEWEST"></h4>
            <ul>
                @foreach ($latest as $relatedContent)
                    <li class="news-box__item">
                        <a href="/community/article/{{$relatedContent->id}}/content" class="news-box__link">
                            {{$relatedContent->title}}
                        </a>
                        <time class="news-box__date">
                            (@{{ <?= strtotime($relatedContent->createdAt) ?> | date: 'mediumDate' }})
                        </time>
                    </li>
                @endforeach
            </ul>
        </aside>
    </div>
</article>