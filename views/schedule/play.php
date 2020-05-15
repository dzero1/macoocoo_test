<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Play Match';
$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="schedule-form">

        <?php $form = ActiveForm::begin(); 

        echo "<div class='row'>";
            echo "<div class='col-6'>";
            echo $form->field($model, 'team1_trys')->textInput(['type' => 'number']);
            echo "</div>";
            echo "<div class='col-6'>";
            echo$form->field($model, 'team1_conversions')->textInput(['type' => 'number']);
            echo "</div>";
        echo "</div>";

        echo "</br>";

        echo "<div class='row'>";
            echo "<div class='col-6'>";
            echo$form->field($model, 'team2_trys')->textInput(['type' => 'number']);
            echo "</div>";
            echo "<div class='col-6'>";
            echo $form->field($model, 'team2_conversions')->textInput(['type' => 'number']);
            echo "</div>";
        echo "</div>";
        ?>

        <div class="form-group">
            <?= Html::submitButton('Finish Match', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
