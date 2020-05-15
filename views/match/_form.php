<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Match */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="match-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'schedule_id')->textInput() ?>

    <?= $form->field($model, 'team1_trys')->textInput() ?>

    <?= $form->field($model, 'team2_trys')->textInput() ?>

    <?= $form->field($model, 'team1_conversions')->textInput() ?>

    <?= $form->field($model, 'team2_conversions')->textInput() ?>

    <?= $form->field($model, 'team1_bonus')->textInput() ?>

    <?= $form->field($model, 'team2_bonus')->textInput() ?>

    <?= $form->field($model, 'team1_total')->textInput() ?>

    <?= $form->field($model, 'team2_total')->textInput() ?>

    <?= $form->field($model, 'winner')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
