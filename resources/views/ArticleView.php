<!-- View stored in resources/views/ArticleView.php -->

<article>
    <?php $articleContent = DB::select('SELECT * FROM azure_articles WHERE id = :id', [':id' => $article])[0]; ?>
    <header class="news-header news-header--single">
        <div class="news-header__banner">
            <figure class="news-header__viewport">
                <img src="<?= $articleContent->imageUrl ?>"
                     alt="<?= $articleContent->title ?>"
                     class="news-header__image news-header__image--featured">
            </figure>
        </div>
        <habbo-social-share type="news"></habbo-social-share>
        <h1 class="news-header__wrapper news-header__title">Race to the limit!</h1>
        <aside class="news-header__wrapper news-header__info">
            <time class="news-header__date">
                {{ <?= strtotime($articleContent->createdAt) ?> | date: 'mediumDate' }}
            </time>
            <ul class="news-header__categories">
                <?php foreach (explode(',', $articleContent->categories) as $articleCategory): ?>
                    <?php $articleCategoryContent = DB::select('SELECT * FROM azure_articles_categories WHERE link = :link',
                        [':link' => $articleCategory])[0]; ?>
                    <li class="news-header__category">
                        <a href="/community/category/<?= $articleCategoryContent->link ?>"
                           class="news-header__category__link"
                           translate="<?= $articleCategoryContent->translate ?>"></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <p class="news-header__wrapper news-header__summary">
            <?= $articleContent->description ?>
        </p>
    </header>
    <div class="news-article">
        <?= $articleContent->content ?>
    </div>

    <div class="news-footer">
        <aside class="news-box">
            <h4 translate="NEWS_RELATED"></h4>
            <ul>
                <?php
                $articleCategory = explode(',', $articleContent->categories);
                $articleCategory = end($articleCategory);

                foreach (DB::select('SELECT id, createdAt, title FROM azure_articles WHERE categories LIKE :category LIMIT 5',
                    [':category' => "%$articleCategory%"]) as $relatedContent):
                    ?>
                    <li class="news-box__item">
                        <a href="/community/article/<?= $relatedContent->id ?>/content" class="news-box__link">
                            <?= $relatedContent->title ?>
                        </a>
                        <time class="news-box__date">
                            ({{ <?= strtotime($relatedContent->createdAt) ?> | date: 'mediumDate' }})
                        </time>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <aside class="news-box">
            <h4 translate="NEWS_NEWEST"></h4>
            <ul>
                <?php foreach (DB::select('SELECT id, createdAt, title FROM azure_articles ORDER BY id ASC LIMIT 5') as $relatedContent):
                    ?>
                    <li class="news-box__item">
                        <a href="/community/article/<?= $relatedContent->id ?>/content" class="news-box__link">
                            <?= $relatedContent->title ?>
                        </a>
                        <time class="news-box__date">
                            ({{ <?= strtotime($relatedContent->createdAt) ?> | date: 'mediumDate' }})
                        </time>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
    </div>
</article>