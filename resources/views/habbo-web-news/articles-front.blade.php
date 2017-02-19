<section>
    @foreach ($set as $articleContent)
        <article class="news-header news-header--column">
            @if($articleContent->roomId != 0)
                <a href="/hotel?room={{$articleContent->roomId}}"
                   class="news-header__link news-header__banner">
                    <figure class="news-header__viewport">
                        <img src="{{$articleContent->thumbnailUrl}}"
                             alt="{{$articleContent->title}}" class="news-header__image news-header__image--thumbnail">
                        <img src="{{$articleContent->imageUrl}}"
                             alt="{{$articleContent->title}}" class="news-header__image news-header__image--featured">
                    </figure>
                </a>
                <a href="/hotel?room={{$articleContent->roomId}}" class="news-header__link news-header__wrapper">
                    <h2 class="news-header__title">{{$articleContent->title}}</h2>
                </a>
            @else
                <a href="/community/article/{{$articleContent->id}}/content"
                   class="news-header__link news-header__banner">
                    <figure class="news-header__viewport">
                        <img src="{{$articleContent->thumbnailUrl}}"
                             alt="{{$articleContent->title}}" class="news-header__image news-header__image--thumbnail">
                        <img src="{{$articleContent->imageUrl}}"
                             alt="{{$articleContent->title}}" class="news-header__image news-header__image--featured">
                    </figure>
                </a>
                <a href="/community/article/{{$articleContent->id}}/content" class="news-header__link news-header__wrapper">
                    <h2 class="news-header__title">{{$articleContent->title}}</h2>
                </a>
            @endif
            <aside class="news-header__wrapper news-header__info">
                <time class="news-header__date">
                    {{date('M j, Y' , strtotime($articleContent->createdAt))}}
                </time>
                <ul class="news-header__categories">
                    @foreach ($articleContent->categories as $articleCategory)
                        <li class="news-header__category">
                            <a href="/community/category/{{$articleCategory->name}}"
                               class="news-header__category__link"
                               translate="{{$articleCategory->translate}}"></a>
                        </li>
                    @endforeach
                </ul>
            </aside>
            <p class="news-header__wrapper news-header__summary">{{$articleContent->description}}</p>
        </article>
    @endforeach
</section>