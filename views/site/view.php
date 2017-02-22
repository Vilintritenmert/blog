<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;

$this->title='Blog - '. $post->title;
?>
<div class="site-view">
    <h1><?= $post->title; ?></h1>
    <div class="description">
        <?php if($post->image): ?>
            <img src="<?=$post->image?>" alt="<?=$post->title?>">
        <?php endif ?>
        <?php if($post->video): ?>
            <video width="320" height="240" controls>
                <source src="<?=$post->video?>">
                Your browser does not support the video tag.
            </video>
        <?php endif ?>
        <?= $post->description ?>
    </div>
    <?php if (count($post->comments)): ?>
        <div class="comments">
            <?php foreach ($post->comments as $comment): ?>
                <div class="comment">
                    <div class="title">
                        <?= $comment->name ?>
                        <div class="pull-right">
                            <?= $comment->created ?>
                        </div>
                    </div>
                    <div class="text"><?= $comment->text ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif ?>

    <?php $form = ActiveForm::begin([
        'id' => 'comment-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 control-label'],
        ],
    ]); ?>

    <?= $form->field($commentForm, 'post_id')->hiddenInput(['value'=> $post->id])->label(false);?>

    <?= $form->field($commentForm, 'name')->textInput(['autofocus' => true, 'placeholder' => 'name'])->label(false) ?>

    <?= $form->field($commentForm, 'email')->textInput(['placeholder' => 'email'])->label(false) ?>

    <?= $form->field($commentForm, 'text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ])->label(false) ?>

    <div class="form-group">
        <div class="">
            <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

