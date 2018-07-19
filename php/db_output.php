<?php
//dummy_get
session_start();
$_SESSION = $_GET;
$dummy = $_SESSION['noparam'];

//DBコネクト
require_once('db_connect.php');

//DBから点数昇順でデータ取り出す
$query = "SELECT * FROM rank ORDER BY score ASC";
$row = $dbh->query($query);

//取り出したデータを変数にHTMLタグとともに格納
foreach($row as $rows){
    $score = $rows['score'];    #合計点を取り出し
    $team = $rows['team'];      #チーム名を取り出し
    
    $middle = "<tr><td><h5>{$team}</h5></td><td><h5>{$score}pt</h5></td></tr>{$middle}";
}

$time = date("Y年m月d日H時i分s秒");
$date = "{$time}　更新";

//結合
$first = "<p>{$date}</p><br><table class=\"container centered\"><thead><tr><th>チーム名</th><th>ポイント</th></tr></thead><tbody id=\"scorelist\">";
$last = "</tbody></table>";
$print_html = "{$first}{$middle}{$last}";

//HTML表示
print "{$print_html}";

?>