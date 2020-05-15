<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Matches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="match-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- < ?= Html::a('Create Match', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'schedule_id',
            /* 'team1_trys',
            'team2_trys',
            'team1_conversions',
            'team2_conversions', */
            //'team1_bonus',
            //'team2_bonus',
            //'team1_total',
            //'team2_total',
            //'winner',
            //'status',
            //'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-eye"></span> View', $url, [
                            'title' => 'View',
                            'class' => 'btn btn-primary btn-sm view',
                            'data-method' => 'post',
                            'style' => ' text-decoration: none; }',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
