<?php
//DBコネクト
require_once('db_connect.php');

//DBデータ削除
$dbh->query("DELETE FROM competitor");

//データをリスト化し、DB挿入
$comrdy = $dbh->prepare("INSERT INTO competitor (class,rank,name,team) VALUES (:list_class,:list_rank,:list_name,:list_team)");




foreach($competitors as $competitor_classes => $competitor_class){
    $list_class = $competitor_classes;
    $already = array(); #既出チーム配列
    $com_pre_team_rank =0;
    $com_team_rank = 1;
    $com_rank_buffer = 0;
    $com_pre_rank = 0;
    
    foreach($competitor_class as list($list_rank,$list_name,$list_team)){
        if(!in_array($list_team,array_column($already,'team'))){
            # 前回確定したチームと同着の場合
            if($list_rank == $com_pre_rank){
                $com_team_rank = $com_pre_team_rank;
                $com_rank_buffer++;
            }
            # 前回確定したチームと同着でない場合
            else{
                $com_team_rank = $com_pre_team_rank + $com_rank_buffer + 1;
                $com_pre_team_rank = $com_team_rank;
                $com_rank_buffer = 0;
            }
            
            $comrdy->bindValue(':list_class',$list_class,PDO::PARAM_STR);
            $comrdy->bindValue(':list_rank',$com_team_rank,PDO::PARAM_INT);
            $comrdy->bindValue(':list_name',$list_name,PDO::PARAM_STR);
            $comrdy->bindValue(':list_team',$list_team,PDO::PARAM_STR);
            $comrdy->execute();
            array_push($already,array('team'=>$list_team));   
        }
    }
}
?>