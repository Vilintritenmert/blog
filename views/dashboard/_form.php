<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

$this->registerJs("CKEDITOR.plugins.addExternal('youtube', '/plugins/ckeditor-youtube-plugin/youtube/', 'plugin.js');");

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'placeholder'=>'Title'])->label(false) ?>

    <div class="row">
        <div class="col-lg-8">
            <?= $form->field($model, 'short_description')->textarea(['maxlength' => true, 'placeholder'=>'Short Description'])->label(false) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'publicated')->checkbox() ?>
        </div>
    </div>

    <?= $form->field($model, 'description')
             ->widget(CKEditor::className(), [
                 'options' => ['rows' => 6],
                 'preset'       =>'full',
                 'clientOptions' => [
                     'extraPlugins' => 'youtube',
                 ]             ])
             ->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
