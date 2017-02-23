<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use app\components\PostViewWidget;

$this->title='Blog - ' . $post->title;
?>
<div class="site-view">

    <?=PostViewWidget::widget([
        'post'=>$post
    ])?>

    <?php if (count($post->comments)): ?>
        <div class="container">
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
        </div>
    <?php endif ?>

    <?php if (Yii::$app->user->getIsGuest()): ?>
        <?php $form=ActiveForm::begin([
            'id'         =>'comment-form',
            'layout'     =>'horizontal',
            'fieldConfig'=>[
                'template'    =>"{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
                'labelOptions'=>['class'=>'col-lg-12 control-label'],
            ],
        ]); ?>

        <?= $form->field($commentForm, 'post_id')
                 ->hiddenInput(['value'=>$post->id])
                 ->label(false); ?>

        <div class="row">
            <div class="col-md-8">
                <?= $form->field($commentForm, 'name')
                         ->textInput(['autofocus'=>true, 'placeholder'=>'name'])
                         ->label(false) ?>
            </div>
            <div class="col-md-1">
                    <?= Html::submitButton('Send', ['class'=>'btn btn-primary', 'name'=>'login-button']) ?>
            </div>
        </div>


        <?= $form->field($commentForm, 'email')
                 ->textInput(['placeholder'=>'email'])
                 ->label(false) ?>

        <?= $form->field($commentForm, 'text')
                 ->widget(CKEditor::className(), [
                     'preset'       =>'custom',
                     'clientOptions'=>[
                         'toolbarGroups'=>[
                             ['name'=>'basicstyles', 'groups'=>['basicstyles', 'cleanup']],
                         ],
                     ],
                 ])
                 ->label(false) ?>


        <?php ActiveForm::end(); ?>
    <?php endif ?>

</div>

