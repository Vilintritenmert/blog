<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Invite */

$this->title = 'Send Invite';

$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['users']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true,'placeholder'=>'email'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton( 'Send' , ['class' => 'btn btn-success' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
