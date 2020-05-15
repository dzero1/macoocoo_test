<?php

namespace app\controllers;

use Yii;

use app\models\Schedule;
use app\models\Match;
use app\models\Teams;
use app\models\Tournament;
use app\models\TournamentSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TournamentController implements the CRUD actions for Tournament model.
 */
class TournamentController extends Controller
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
     * Lists all Tournament models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TournamentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tournament model.
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
     * Creates a new Tournament model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tournament();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tournament model.
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
     * Deletes an existing Tournament model.
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
     * Finds the Tournament model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tournament the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tournament::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public static function getTheWinner($id){
    
        $all_match = Schedule::find()
            ->where(['tournament_id' => $id])->count();

        $remaining_match = Schedule::find()
            ->where(['tournament_id' => $id])
            ->andWhere(['not', ['status' => 'Finished']])->count();
        
        if ($all_match == 0 || $remaining_match > 0){
            return 'TBA';
        } else {
    
            $winner;
            $winning_counts = [];
    
            $schedules = Schedule::find()->where(['tournament_id' => $id])->all();

            foreach ($schedules as $sch) {
                $match = Match::findOne(['schedule_id'=>$sch->id]);
    
                if (!isset($winning_counts[$match->winner])) $winning_counts[$match->winner] = 0;
                $winning_counts[$match->winner]++;
            }

            $most_winner_duplicate = [];
            $most_win_count = 0;
    
            /* Gather most winner */
            foreach ($winning_counts as $team => $count) {
                if ($most_win_count < $count) {
                    $most_win_count = $count;
                    $winner = $team;
                    $most_winner_duplicate = [$team];
    
                // If another equel team
                } else if ($most_win_count == $count) {
                    $most_winner_duplicate[] = $team;
                }
            }

    
            $team_bonus = [];
            if (count($most_winner_duplicate) > 1){
    
                /* Gather bonus amounts */
                foreach ($most_winner_duplicate as $team) {
                    $matchs = Match::findAll(['winner' => $team]);
                    $bonus = 0;
                    foreach ($matchs as $key => $match) {
                        $sch = Schedule::findOne($match->schedule_id);
                        $bonus += ($sch->team1 == $team) ? $match->team1_bonus : $match->team2_bonus;
                    }
                    $team_bonus[$team] = $bonus;
                }
    
                $max_bonus = 0;
                $bonus_duplicates = [];
                foreach ($team_bonus as $team => $bonus) {
                    if ($max_bonus < $bonus) {
                        $winner = $team;
                        $bonus_duplicates = [$team];
                    } else if ($max_bonus > $bonus) {
                        $bonus_duplicates[] = $team;
                    }
                }
    
                if (count($bonus_duplicates) > 1){
                    
                    /* Gather bonus amounts */
                    foreach ($bonus_duplicates as $team) {
                        $matchs = Match::findAll(['winner' => $team]);
                        $total = 0;
                        foreach ($matchs as $key => $match) {
                            $sch = Schedule::findOne($match->schedule_id);
                            if ($sch->team1 == $team){
                                $total += ($match->team1_trys*5) + ($match->team1_conversions*3) + ($match->team1_bonus);
                            } else {
                                $total += ($match->team2_trys*5) + ($match->team2_conversions*3) + ($match->team2_bonus);
                            }
                        }
                        $team_total[$team] = $total;
                    }
    
                    $max_total = 0;
                    $total_duplicates = [];
                    foreach ($team_total as $team => $total) {
                        if ($max_total < $total) {
                            $winner = $team;
                            $total_duplicates = [$team];
                        } else if ($max_total > $total) {
                            $total_duplicates[] = $team;
                        }
                    }
    
                    if (count($total_duplicates) > 1){
                        $teams = [];
                        foreach ($total_duplicates as $team) {
                            $teams[] = Teams::findOne($team)->display_name;
                        }
                        return implode(", ", $teams);
                    } else {
                        return Teams::findOne($winner)->display_name;
                    }
    
                } else {
                    return Teams::findOne($winner)->display_name;
                }
    
            } else {
                return Teams::findOne($winner)->display_name;
            }
        }
    
    }
    
}
