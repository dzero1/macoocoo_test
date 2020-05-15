<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MatchSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="match-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'schedule_id') ?>

    <?= $form->field($model, 'team1_trys') ?>

    <?= $form->field($model, 'team2_trys') ?>

    <?= $form->field($model, 'team1_conversions') ?>

    <?php // echo $form->field($model, 'team2_conversions') ?>

    <?php // echo $form->field($model, 'team1_bonus') ?>

    <?php // echo $form->field($model, 'team2_bonus') ?>

    <?php // echo $form->field($model, 'team1_total') ?>

    <?php // echo $form->field($model, 'team2_total') ?>

    <?php // echo $form->field($model, 'winner') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
