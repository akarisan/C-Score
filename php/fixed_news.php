<?php
//dummy_get
session_start();
$_SESSION = $_GET;
$dummy = $_SESSION['noparam'];

//DBコネクト
require_once('db_connect.php');

//セレクト
$fixed_row = $dbh->query("SELECT * FROM competitor WHERE fixed LIKE 'fixed' ORDER BY class ASC");

//ニュース型
foreach($fixed_row as $fixed_rows){
    $f_class = $fixed_rows['class'];
    $f_rank = $fixed_rows['rank'];
    $f_name = $fixed_rows['name'];
    $f_team = $fixed_rows['team'];
    
    $fixed_news = "{$fixed_news}《{$f_class}：{$f_rank}位》{$f_name}（{$f_team}）　　";
}

//表示
print "【確定情報】{$fixed_news}";

?>