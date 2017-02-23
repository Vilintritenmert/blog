<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */

$this->title='My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
            <?php foreach ($posts as $post): ?>
                <div class="article">
                    <div class="title"><?=Html::a($post->title,'/site/view?id='.$post->id)?></a></div>

                    <p><?=$post->short_description ?></p>
                    <div class="details">
                        <div class="pull-left">
                            <?=$post->created;?>
                        </div>
                        <div class="pull-right">
                            <?=$post->author->username;?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
    </div>
</div>

<div class="clr"></div>
<div class="text-center">
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>

