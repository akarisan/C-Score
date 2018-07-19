<?php
//DBコネクト
require_once('db_connect.php');

//チーム名、スコアを取得
$before_score_row = $dbh->query("SELECT * FROM rank");

//更新前のスコアを挿入
foreach($before_score_row as $before_score_rows){
    $before_score = $before_score_rows['score'];
    $before_team = $before_score_rows['team'];
    $dbh->query("UPDATE rank SET bef_score = $before_score WHERE team LIKE 
    '$before_team'");
}
?>