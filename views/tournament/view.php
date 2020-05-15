<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\controllers\TournamentController;

/* @var $this yii\web\View */
/* @var $model app\models\Tournament */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tournaments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tournament-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'display_name',
            [
                'attribute' => 'logo',
                'format' => 'html',
                'value' => function($model){
                    return "<img src='{$model->logo}' style='max-width:100px; height:auto;' />";
                }
            ],
            [
                'attribute' => 'id',
                'value' => function($model){
                    return TournamentController::getTheWinner($model->id);
                }
            ],
            //'created_at',
        ],
    ]) ?>

</div>


<?php



?>