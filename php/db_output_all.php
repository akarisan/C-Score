<?php
//dummy_get
session_start();
$_SESSION = $_GET;
$dummy = $_SESSION['noparam'];

//公開時間より前かどうかの判断
if(strtotime("now") > strtotime("2019-10-06 08:00:00")){
    print "<div class=\"layout\"><div class=\"loader\">Loading...</div><h1>イベント終了</h1><p>for Tortoise Club Cup Middle<br>Live Score Result System<br>C-Score</p><h6>本サイトはイベント終了につき、閉鎖しました。</h6></div>";
    exit();
}

//DBコネクト
require_once('db_connect.php');

//DB「access_last」が「false」ならtrに「no-animation」クラスを追加する
if($access_last == false){
    $add_class_anime = "no-animation";
}

//DBから点数昇順でデータ取り出す
$query = "SELECT * FROM rank ORDER BY score DESC";
$row = $dbh->query($query);

$ranking = 0;   #チームごとの順位
$max_score = 0;
$same_rank = 1;
$other_score = 0;

//取り出したデータを変数にHTMLタグとともに格納
foreach($row as $rows){
    $score = $rows['score'];            #合計点を取り出し
    $bef_score = $rows['bef_score'];    #前回のスコア
    $team = $rows['team'];              #チーム名を取り出し
    $path = "https://lo-ope.com/cs/img/logo/{$rows['path']}";   #ロゴ画像パス
    $alert = "";                        #チーム内の貢献者リスト
    $add_class = "";                    #アニメ用
    $move_score = "";                   #スコア変動の視覚化
    $df_score = 0;                      #スコア差    
    $line_graf = "";
    //矢印の振り分け
    if($score == $bef_score){
        $move_score = "（―）";
        $add_class_anime = "class=\"no-animation\"";
    }else if($score > $bef_score){
        $move_score = "（↗）";
    }else if($score < $bef_score){
        $move_score = "（↘）";
    }else{
        $move_score = "Error";
    }
    
    //最高スコアと棒グラフ
    if($max_score >= $score){
        $calc = $score/$max_score*100;
        $line_graf = "<div id=\"line-box\" style=\"width:{$calc}%;\"><div id=\"line\"></div></div>";
    }else if($max_score < $score){
        $max_score = $score;
        $line_graf = "<div id=\"line-box\" style=\"width:100%;\"><div id=\"line\"></div></div>";
    }else{
        $line_graf = "";
    }
    
    //DBからチーム名で取得
    $col = $dbh->query("SELECT * FROM competitor WHERE team LIKE '$team'");
    foreach($col as $cols){
        $com_name = $cols['name'];
        $com_rank = $cols['rank'];
        $com_class = $cols['class'];
        $com_fix = $cols['fixed'];
        if($com_fix === "fixed"){
            $com_name = "<span style=\"color:red;\">{$com_name}</span>";
        }
        $alert = "{$alert}<br>《{$com_class}》{$com_rank}位：{$com_name}";
    }
    
    //同順位時の処理
    if($score == $other_score){
        $same_rank++;
    }else{
        $ranking = $ranking + $same_rank;
        $other_score = $score;
        $same_rank = 1;
    }
    
    $middle = "{$middle}<tr {$add_class_anime}><td><h5>{$ranking}</h5></td><td id=\"img-logo\"><img src=\"{$path}\"></td><td><h5>{$team}</h5><details><summary>ポイント詳細</summary><p style=\"display:block;\">{$alert}</p></details></td><td><h5>{$score}pt<small class=\"text-center\">{$move_score}</small></h5>{$line_graf}</td></tr>";
    
    
}

//最終更新時刻
$time = date("Y年m月d日H時i分s秒");
$date = "{$time}　更新";

//結合
$first = "<p>{$date}</p><br><table class=\"container centered striped\"><tbody>";
$last = "</tbody></table>";
$print_html = "{$first}{$middle}{$last}";

//HTML表示
print "{$print_html}";
?>