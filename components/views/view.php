<?php
/**
 * @var $post app\models\Post
 **/
?>
<div class="widget-view">
    <div class="post">
        <h1><?= $post->title; ?></h1>
        <small><?= $post->created;?> (<?=$post->author->username;?>)</small>
        <div class="description">
            <?php if ($post->image): ?>
                <img src="<?= $post->image ?>" alt="<?= $post->title ?>">
            <?php endif ?>
            <?php if ($post->video): ?>
                <video width="320" height="240" controls>
                    <source src="<?= $post->video ?>">
                    Your browser does not support the video tag.
                </video>
            <?php endif ?>
            <?= $post->description ?>
        </div>
    </div>
</div>
