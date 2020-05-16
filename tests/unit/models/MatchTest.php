<?php

namespace tests\unit\models;

use app\models\Tournament;
use app\models\Schedule;
use app\models\Match;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindWinner()
    {
        expect_that($tournament = Tournament::findOne(1));

        expect_that($schedule = Schedule::find()->where(['tournament_id' => $tournament->id, 'status' => 'Finished'])->all());

        foreach ($schedule as $sch) {
            expect_that($match = Match::findOne(['schedule_id' => $sch->id]));

            $team1_total = ($match->team1_trys * 5) + ($match->team1_conversions * 3) + $match->team1_bonus;
            $team2_total = ($match->team2_trys * 5) + ($match->team2_conversions * 3) + $match->team2_bonus;

            if ($team1_total > $team2_total){
                expect($match->winner)->equals($sch->team1);        //winner should be team 1
            } else if ($team1_total < $team2_total){
                expect($match->winner)->equals($sch->team2);        //winner should be team 2

            } else {        //if scores tie

                if ($match->team1_bonus > $match->team2_bonus){
                    expect($match->winner)->equals($sch->team1);        //winner should be team 1
                } else if ($match->team1_bonus < $match->team2_bonus){
                    expect($match->winner)->equals($sch->team2);        //winner should be team 2
    
                } else {

                    if ($match->team1_trys > $match->team2_trys){
                        expect($match->winner)->equals($sch->team1);        //winner should be team 1
                    } else if ($match->team1_trys < $match->team2_trys){
                        expect($match->winner)->equals($sch->team2);        //winner should be team 2
        
                    } else {
                        // the random cannot be assess

                    }
                    
                }

            }

        }

    }

}
