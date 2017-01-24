<!-- View stored in resources/views/ArticlesFront.php -->

<section>
    <?php foreach (DB::select('SELECT * FROM azure_articles ' .
        'WHERE categories LIKE :category  ORDER BY id ASC LIMIT 10',
        [':category' => "%all%"]) as $articleContent): ?>
        <article class="news-header news-header--column">
            <a href="/community/article/<?= $articleContent->id ?>" class="news-header__link news-header__banner">
                <figure class="news-header__viewport">
                    <img src="<?= $articleContent->thumbnailUrl ?>"
                         alt="<?= $articleContent->title ?>" class="news-header__image news-header__image--thumbnail">
                    <img src="<?= $articleContent->imageUrl ?>"
                         alt="Race to the limit!" class="news-header__image news-header__image--featured">
                </figure>
            </a>
            <a href="/community/article/<?= $articleContent->id ?>" class="news-header__link news-header__wrapper">
                <h2 class="news-header__title"><?= $articleContent->title ?></h2>
            </a>
            <aside class="news-header__wrapper news-header__info">
                <time class="news-header__date">
                    {{ <?= strtotime($articleContent->createdAt) ?> | date: 'mediumDate' }}
                </time>
                <ul class="news-header__categories">
                    <?php foreach (explode(',', $articleContent->categories) as $articleCategory): ?>
                        <?php $articleCategoryContent = DB::select('SELECT * FROM azure_articles_categories WHERE link = :link',
                            [':link' => $articleCategory])[0]; ?>
                        <li class="news-header__category">
                            <a href="/community/category/<?= $articleCategoryContent->link ?>/content"
                               class="news-header__category__link"
                               translate="<?= $articleCategoryContent->translate ?>"></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>
            <p class="news-header__wrapper news-header__summary"><?= $articleContent->description ?></p>
        </article>
    <?php endforeach; ?>
</section>