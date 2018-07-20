<?php
//dummy_get
session_start();
$_SESSION = $_GET;
$dummy = $_SESSION['noparam'];

//DBコネクト
require_once('db_connect.php');

//DBから点数昇順でデータ取り出す
$query = "SELECT * FROM rank ORDER BY score DESC";
$row = $dbh->query($query);

$ranking = 1;   #チームごとの順位

//取り出したデータを変数にHTMLタグとともに格納
foreach($row as $rows){
    $score = $rows['score'];            #合計点を取り出し
    $bef_score = $rows['bef_score'];    #前回のスコア
    $team = $rows['team'];              #チーム名を取り出し
    $alert = "";                        #チーム内の貢献者リスト
    $add_class = "";                    #アニメ用
    $move_score = "";                   #スコア変動の視覚化
    $df_score = 0;                      #スコア差    
    //矢印の振り分け
    if($score == $bef_score){
        $move_score = "（―）";
    }else if($score > $bef_score){
        $df_score = $score -$bef_score;
        $move_score = "（↗）{$df_score}pt";
    }else if($score < $bef_score){
        $df_score = $bef_score - $score;
        $move_score = "（↘）{$df_score}pt";
    }else{
        $move_score = "Error";
    }
    
    //DBからチーム名で取得
    $col = $dbh->query("SELECT * FROM competitor WHERE team LIKE '$team'");
    foreach($col as $cols){
        $com_name = $cols['name'];
        $com_rank = $cols['rank'];
        $com_class = $cols['class'];
        $alert = "{$alert}<p>《{$com_class}》{$com_rank}位：{$com_name}</p>";
    }
    
    $middle = "{$middle}<tr><td><h5>{$ranking}</h5></td><td><h5>{$team}</h5>{$alert}</td><td><h5>{$score}pt</h5><p class=\"text-left\">{$move_score}</p></td></tr>";
    $ranking++;
}

//最終更新時刻
$time = date("Y年m月d日H時i分s秒");
$date = "{$time}　更新";

//結合
$first = "<p>{$date}</p><br><table class=\"container centered\"><tbody id=\"scorelist\">";
$last = "</tbody></table>";
$print_html = "{$first}{$middle}{$last}";

//HTML表示
print "{$print_html}";

?>