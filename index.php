<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require 'vendor/autoload.php';

function getDB(){
    $db = parse_ini_file("db.ini");    
    $dbhost = $db['host'];
    $dbuser = $db['user'];
    $dbpass = $db['password'];
    $dbname = $db['dbname'];
 
    $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
    $dbConnection = new PDO($mysql_conn_string, $dbuser, $dbpass); 
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConnection;
}

$app = new \Slim\Slim();
$app->get('/api/v1/fixture/:id', function($id) use($app) {
    
    $app = \Slim\Slim::getInstance();
    
    try{
        $db = getDB();
        $sth = $db->prepare("SELECT f.id,t1.name as Home , t2.name as Away ,t1.code as h_code , t2.code as a_code, f.match_date as date 
                            FROM `teams` t1 JOIN `fixtures` f ON t1.id = f.home_id 
                            JOIN `teams` t2 ON t2.id = f.away_id WHERE `l_id` = :id AND `status` = 'TIMED' order by `match_date`
                    ");
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $fixture = $sth->fetchAll(PDO::FETCH_OBJ);
        if($fixture) {
                $app->response->setStatus(200);
                $app->response()->headers->set('Content-Type', 'application/json');
                echo json_encode($fixture);
                $db = null;
        } else {
                throw new PDOException('No records found.');
        }
    }  catch (PDOException $e){
        $app->response()->setStatus(500);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}); 
 
$app->get('/api/v1/results/:id',function($id) use ($app){
    $app = \Slim\Slim::getInstance();
    try{
        $db = getDB();
        $sth = $db->prepare("SELECT f.id,t1.name as Home ,f.goals_home_team as Goal_Home , 
                             f.goals_away_team as Goal_Away ,t2.name as Away , f.match_date as date 
                             FROM `teams` t1 JOIN `fixtures` f ON t1.id = f.home_id 
                             JOIN `teams` t2 ON t2.id = f.away_id WHERE `l_id` = :id 
                             AND `status` = 'FINISHED' order by `match_date` DESC");
        $sth->bindParam(":id", $id,  PDO::PARAM_INT);
        $sth->execute();
        $results = $sth->fetchAll(PDO::FETCH_OBJ);
        if( $results ){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode( $results );
            $db = null;                    
        }
    } catch (PDOException $ex) {
        $app->response()->setStatus(500);
        echo '{"error":{"text":'.$ex->getMessage().'}}';
    }
});

$app->get("/api/v1/standings/:id",function($id) use($app){
    $app = \Slim\Slim::getInstance();
    try{
        $db = getDB();
        $sth = $db->prepare("SELECT t.name,l.played,l.wins,l.draws,l.losses,l.goal_for,l.goal_against,l.goal_diff,l.points 
                             FROM `league_table` l JOIN `teams` t ON l.t_id = t.id AND l.l_id = t.league_id 
                             WHERE `l_id` = :id ORDER BY `points`DESC");
        $sth->bindParam(":id", $id,  PDO::PARAM_INT);
        $sth->execute();
        $results = $sth->fetchAll(PDO::FETCH_OBJ);
        if( $results ){
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode( $results );
            $db = null;                    
        }
    } catch (PDOException $ex) {
        $app->response()->setStatus(500);
        echo '{"error":{"text":'.$ex->getMessage().'}}';
    }
});
$app->run();