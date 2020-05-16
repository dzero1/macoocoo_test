<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Schedule;
use app\models\Teams;

/* @var $this yii\web\View */
/* @var $model app\models\Match */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Matches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="match-view">

    <!-- <h1>< ?= Html::encode($this->title) ?></h1> -->

    <p>
        <!-- < ?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        < ?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
        <?= Html::a('<svg class="bi bi-arrow-left-short" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M7.854 4.646a.5.5 0 010 .708L5.207 8l2.647 2.646a.5.5 0 01-.708.708l-3-3a.5.5 0 010-.708l3-3a.5.5 0 01.708 0z" clip-rule="evenodd"/>
            <path fill-rule="evenodd" d="M4.5 8a.5.5 0 01.5-.5h6.5a.5.5 0 010 1H5a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>
            </svg>', ['index'], ['class' => 'btn btn-dark']) ?>
        <!-- < ?= Html::a('Go to match schedules', ['/schedule'], ['class' => 'btn btn-primary']) ?> -->
    </p>

    <h1>Winner: <?= Teams::findOne($model->winner)->display_name ?></h1>
    <h5>Match Status: <?= $model->status ?></h5>
    </br>
    </br>
    <div class="row">
        <div class="col-6">
            <h4><?= Teams::findOne(Schedule::findOne($id)->team1)->display_name ?></h4>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    //'schedule_id',
                    [
                        'attribute' => 'team1_trys',
                        'label' => 'Trys'
                    ],
                    [
                        'attribute' => 'team1_conversions',
                        'label' => 'Conversions'
                    ],
                    [
                        'attribute' => 'team1_bonus',
                        'label' => 'Bonus'
                    ],
                    [
                        'attribute' => 'team1_total',
                        'label' => 'Total'
                    ],
                    //'status',
                    //'created_at',
                ],
            ]) ?>
        </div>
        <div class="col-6">
            <h4><?= Teams::findOne(Schedule::findOne($id)->team2)->display_name ?></h4>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    //'schedule_id',
                    [
                        'attribute' => 'team2_trys',
                        'label' => 'Trys'
                    ],
                    [
                        'attribute' => 'team2_conversions',
                        'label' => 'Conversions'
                    ],
                    [
                        'attribute' => 'team2_bonus',
                        'label' => 'Bonus'
                    ],
                    [
                        'attribute' => 'team2_total',
                        'label' => 'Total'
                    ],
                    //'status',
                    //'created_at',
                ],
            ]) ?>
        </div>
    </div>


</div>
