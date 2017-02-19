<article>
    <header class="news-header news-header--single">
        <div class="news-header__banner">
            <figure class="news-header__viewport">
                <img src="<?php echo e($article->imageUrl); ?>"
                     alt="<?php echo e($article->title); ?>"
                     class="news-header__image news-header__image--featured">
            </figure>
        </div>
        <habbo-social-share type="news"></habbo-social-share>
        <h1 class="news-header__wrapper news-header__title">Race to the limit!</h1>
        <aside class="news-header__wrapper news-header__info">
            <time class="news-header__date">
                <?php echo e(date('M j, Y' , strtotime($article->createdAt))); ?>

            </time>
            <ul class="news-header__categories">
                <?php $__currentLoopData = $article->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articleCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="news-header__category">
                        <a href="/community/category/<?php echo e($articleCategory->name); ?>"
                           class="news-header__category__link"
                           translate="<?php echo e($articleCategory->translate); ?>"></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </aside>
        <p class="news-header__wrapper news-header__summary">
            <?php echo e($article->description); ?>

        </p>
    </header>
    <div class="news-article">
        <?php echo $article->content; ?>

    </div>

    <div class="news-footer">
        <aside class="news-box">
            <h4 translate="NEWS_RELATED"></h4>
            <ul>
                <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="news-box__item">
                        <a href="/community/article/<?php echo e($relatedContent->id); ?>/content" class="news-box__link">
                            <?php echo e($relatedContent->title); ?>

                        </a>
                        <time class="news-box__date">
                            (<?php echo e(date('M j, Y' , strtotime($relatedContent->createdAt))); ?>)
                        </time>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </aside>
        <aside class="news-box">
            <h4 translate="NEWS_NEWEST"></h4>
            <ul>
                <?php $__currentLoopData = $latest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="news-box__item">
                        <a href="/community/article/<?php echo e($relatedContent->id); ?>/content" class="news-box__link">
                            <?php echo e($relatedContent->title); ?>

                        </a>
                        <time class="news-box__date">
                            (<?php echo e(date('M j, Y' , strtotime($relatedContent->createdAt))); ?>)
                        </time>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </aside>
    </div>
</article>