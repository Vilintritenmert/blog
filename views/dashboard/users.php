<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$this->title='Dashboard';
?>
<div class="dashboard-index">


    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider'=>$dataProvider,
        'filterModel' =>$searchModel,
        'columns'     =>[
            'id',
            'username',
            'email',
            [
                'header' => 'Action',
                'class'   =>ActionColumn::className(),
                'template'=>'{view} {update}',
            ],
        ],
    ]); ?>
</div>
