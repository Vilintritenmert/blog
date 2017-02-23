<?php

/* @var $this yii\web\View */
use app\components\PostViewWidget;

$this->title='My Yii Application';

$this->params[ 'breadcrumbs' ][]=[
    'label'=>'Dashboard',
    'url'  => '/dashboard'
];

?>
<div class="dashboard-view">
    <?= PostViewWidget::widget([
        'post'=>$post,
    ]) ?>
</div>
