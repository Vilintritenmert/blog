<?php

/* @var $this yii\web\View */

$this->title='My Yii Application';
?>
<div class="site-index">


    <div class="body-content">

        <div class="row">
            <?php foreach ($posts as $post): ?>
                <div class="">
                    <h2><?php echo $post->title; ?></h2>

                    <p><?php echo $post->description ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
