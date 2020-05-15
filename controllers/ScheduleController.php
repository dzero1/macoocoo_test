<?php

namespace app\controllers;

use Yii;
use app\models\Teams;
use app\models\Match;
use app\models\Schedule;
use app\models\ScheduleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ScheduleController implements the CRUD actions for Schedule model.
 */
class ScheduleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Schedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Match();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Schedule model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Schedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Schedule();

        if ($model->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->id]);

            /* How the match should shedule

                Teams - A B C D E

                A+B
                A+C
                A+D
                A+E
                B+C
                B+D
                B+E
                C+D
                C+E
                D+E

            */

            Schedule::deleteAll();
            Match::deleteAll();

            $tournament_id = Yii::$app->request->post('Schedule')['tournament_id'];

            $teams = Teams::find()->where(['tournament_id' => $tournament_id])->all();

            for ($i=0; $i < count($teams); $i++) { 
                $team1 = $teams[$i];
                for ($j = $i+1; $j < count($teams); $j++) { 
                    $team2 = $teams[$j];

                    //echo ("{$team1->display_name} + {$team2->display_name}<br>");
                    $sch = new Schedule();
                    $sch->tournament_id = $tournament_id;
                    $sch->team1 = $team1->id;
                    $sch->team2 = $team2->id;
                    $sch->start_at = date('Y-m-d 12:00:00', "+".strtotime(floor(rand(1, 5))." days"));
                    $sch->save();
                }
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Schedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Schedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Schedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPlay($id)
    {
        $model = new Match();

        //var_dump(Yii::$app->request->post('Match')); exit;
        if (Yii::$app->request->post('Match')) {

            $post = Yii::$app->request->post('Match');

            $schedule = Schedule::findOne($id);

            Match::deleteAll(['schedule_id' => $schedule->id]);

            $match = new Match();

            $match->schedule_id = $schedule->id;

            $match->team1_trys = $post['team1_trys'];
            $match->team2_trys = $post['team2_trys'];

            $match->team1_conversions = $post['team1_conversions'];
            $match->team2_conversions = $post['team2_conversions'];

            $match->team1_bonus = ($match->team1_trys >= 3) ? 6 : 0; 
            $match->team2_bonus = ($match->team1_bonus == 0 && $match->team2_trys >= 3) ? 6 : 0; 

            $match->team1_total = ($match->team1_trys*5) + ($match->team1_conversions*3) + $match->team1_bonus;
            $match->team2_total = ($match->team2_trys*5) + ($match->team2_conversions*3) + $match->team2_bonus;

            /* Select a team based on the Total score */
            if ($match->team1_total > $match->team2_total){
                $match->winner = $schedule->team1;
            } else if ($match->team1_total < $match->team2_total){
                $match->winner = $schedule->team2;
            } else {

                /* Select a team based on the Bonus points */
                if ($match->team1_bonus > $match->team2_bonus){
                    $match->winner = $schedule->team1;
                } else if ($match->team1_bonus < $match->team2_bonus){
                    $match->winner = $schedule->team2;
                } else {
                        
                    /* Select a team based on the Total Trys */
                    if ($match->team1_trys > $match->team2_trys){
                        $match->winner = $schedule->team1;
                    } else if ($match->team1_trys < $match->team2_trys){
                        $match->winner = $schedule->team2;
                    } else {

                        /* Select a team based on random */
                        $match->winner = rand(0,1) == 0 ? $schedule->team1 : $schedule->team2;
                        
                    }
                    
                }

            }

            $match->status = "Finished";
            if ($match->save(false)){
                $schedule->status = "Finished";
                $schedule->save(false);
            }
            
            if (Yii::$app->request->isAjax) {
                /* $searchModel = new ScheduleSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $model = new Match();
        
                return $this->renderAjax('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                ]); */
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => true];
            } else {
                return $this->redirect(['match/view', 'id'=>$match->id]);
            }
        }
        
        return $this->render('play', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Match model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionResult($id)
    {
        return $this->render('result', [
            'model' => Match::findOne(['schedule_id'=>$id]),
        ]);
    }

    /**
     * Finds the Schedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Schedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Schedule::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}