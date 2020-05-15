<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $form yii\widgets\ActiveForm */

use app\models\Tournament;

?>

<div class="schedule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tournament_id')->label('Delivery Method')->dropdownList(ArrayHelper::map(Tournament::find()->asArray()->all(), 'id', 'display_name')); ?>

    <!-- < ?= $form->field($model, 'team1')->textInput() ?>

    < ?= $form->field($model, 'team2')->textInput() ?>

    < ?= $form->field($model, 'start_at')->textInput() ?>

    < ?= $form->field($model, 'created_at')->textInput() ?> -->


    <div class="form-group">
        <?= Html::submitButton('Generate Schedule', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
