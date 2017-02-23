<?php
/**
 * @var $post app\models\Post
 **/
?>

<h1><?= $post->title; ?></h1>
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
