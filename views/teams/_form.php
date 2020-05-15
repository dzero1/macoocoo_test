<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\Tournament;

/* @var $this yii\web\View */
/* @var $model app\models\Teams */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="teams-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- < ?= $form->field($model, 'tournament_id')->textInput() ?> -->
    <?= $form->field($model, 'tournament_id')->label('Delivery Method')->dropdownList(ArrayHelper::map(Tournament::find()->asArray()->all(), 'id', 'display_name')); ?>

    <?= $form->field($model, 'display_name')->textInput(['maxlength' => true]) ?>

    <!-- < ?= $form->field($model, 'created_at')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
