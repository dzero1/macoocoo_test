<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use app\models\Match;
use app\models\Teams;


$this->title = 'Schedules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Schedule', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'team1',
                'value' => function($model){
                    return Teams::findOne($model->team1)->display_name;
                }
            ],
            [
                'attribute' => 'team2',
                'value' => function($model){
                    return Teams::findOne($model->team2)->display_name;
                }
            ],
            'start_at',
            //'created_at',
            [
                'attribute' => 'id',
                'label' => 'Winner',
                'value' => function($model){
                    if ($model->status != 'Finished' ){
                        return 'TBA';
                    } else {
                        return Teams::findOne((Match::findOne(['schedule_id'=>$model->id]))->winner)->display_name;
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{play}{result}',
                'buttons' => [
                    'play' => function ($url, $model) {
                        //if ($model->status != 'Finished'){
                            return Html::a('<span class="fa fa-eye"></span> Play', '', [
                                'title' => 'Play',
                                'class' => 'btn btn-primary btn-sm play',
                                'data-id' => $model->id,
                                'data-url' => $url,
                                'style' => 'text-decoration: none;',
                            ]);
                        //}
                    },
                    'result' => function ($url, $model) {
                        if ($model->status == 'Finished'){
                            return Html::a('<span class="fa fa-eye"></span> Match result', $url, [
                                'title' => 'Match result',
                                'class' => 'btn btn-warning btn-sm result',
                                'data-method' => 'post',
                                'style' => ' text-decoration: none; }',
                            ]);
                        }
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>

<?php 

    $this->registerJs(
        "
        $(document).ready(function() {
            $('.play').click(function(e){
                e.preventDefault();      
                $('#match-id').val($(this).data('id'))
                $('#pModal').modal('show');
                return false;
            });
        });
        
        "
    );

    Modal::begin([
        'id'=>'pModal',
        'size'=>'modal-lg',
        'title' => 'Play the match',
        'clientOptions' => [
            'backdrop' => 'static',
            'keyboard' => false,
        ],
        'clientEvents' => [
            'hidden.bs.modal' => "
                /* function (e) {
                    var mbody = $('#pModal').find('.modal-content').find('.modal-body');
                    mbody.html('');
                } */
            "
        ],
    ]);
    ?>

    <div class="modal-body">
    <?php 
        $form = ActiveForm::begin([
            'id' => 'play-form',
            'action' => 'schedule/play',
            'method' => 'POST',
        ]); 

        echo $form->field($model, 'id')->textInput(['type' => 'hidden'])->label(false);

        echo "<div class='row'>";
            echo "<div class='col-6'>";
            echo $form->field($model, 'team1_trys')->textInput(['type' => 'number']);
            echo "</div>";
            echo "<div class='col-6'>";
            echo $form->field($model, 'team1_conversions')->textInput(['type' => 'number']);
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
    </div>
    <div class="modal-footer">
        <?= Html::submitButton('Finish Match', ['class' => 'btn btn-success']) ?>
    </div>

    <?php 
    
    ActiveForm::end();

    Modal::end();

    $this->registerJs(

        "$('#play-form').on('beforeSubmit', function(e) {
            var form = $(this);
            var formData = form.serialize();
            $.ajax({
                url: form.attr('action')+'?id='+$('#match-id').val(),
                type: form.attr('method'),
                data: formData,
                success: function (data) {
                    if (data.success == true){
                        document.location.reload();
                    } else {
                        alert('Error updating data');
                    }
                },
                error: function () {
                    alert('Something went wrong');
                }
            });
        }).on('submit', function(e){
            e.preventDefault();
        });"
    
    );
    