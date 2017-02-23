<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */

$this->title='My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <?php foreach ($posts as $post): ?>
                <div class="">
                    <h2><?=Html::a($post->title,'/site/view?id='.$post->id)?></a></h2>

                    <p><?php echo $post->short_description ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?= LinkPager::widget([
    'pagination' => $pages,
]); ?>

