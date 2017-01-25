<section>
    <?php $__currentLoopData = $set; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articleContent): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
        <article class="news-header news-header--column">
            <a href="/community/article/<?php echo e($articleContent->id); ?>/content" class="news-header__link news-header__banner">
                <figure class="news-header__viewport">
                    <img src="<?php echo e($articleContent->thumbnailUrl); ?>"
                         alt="<?php echo e($articleContent->title); ?>" class="news-header__image news-header__image--thumbnail">
                    <img src="<?php echo e($articleContent->imageUrl); ?>"
                         alt="Race to the limit!" class="news-header__image news-header__image--featured">
                </figure>
            </a>
            <a href="/community/article/<?php echo e($articleContent->id); ?>/content" class="news-header__link news-header__wrapper">
                <h2 class="news-header__title"><?php echo e($articleContent->title); ?></h2>
            </a>
            <aside class="news-header__wrapper news-header__info">
                <time class="news-header__date">
                    @{{ <?= strtotime($articleContent->createdAt) ?> | date: 'mediumDate' }}
                </time>
                <ul class="news-header__categories">
                    <?php $__currentLoopData = $articleContent->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articleCategory): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <li class="news-header__category">
                            <a href="/community/category/<?php echo e($articleCategory->link); ?>/content"
                               class="news-header__category__link"
                               translate="<?php echo e($articleCategory->translate); ?>"></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </ul>
            </aside>
            <p class="news-header__wrapper news-header__summary"><?php echo e($articleContent->description); ?></p>
        </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
</section>