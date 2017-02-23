<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title                    ='Update User: ' . $model->username;
$this->params[ 'breadcrumbs' ][]=['label'=>'Users', 'url'=>['index']];
?>
<div class="post-update">

    <div class="form-signin">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form=ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')
                 ->textInput(['maxlength'=>true, 'placeholder'=>'Name'])
                 ->label(false) ?>

        <?= $form->field($model, 'email')
                 ->textInput(['maxlength'=>true, 'placeholder'=>'Email'])
                 ->label(false) ?>

        <?= Html::checkbox('author', $model->IsAuthor(), ['class'=>'form-controll', 'label'=>'Author']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord? 'Create' : 'Update',
                ['class'=>$model->isNewRecord? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
